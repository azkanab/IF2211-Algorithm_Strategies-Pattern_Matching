#
# PATTERN MATCHING ALGORITHM
#

# Pattern matching with KMP Algorithm
# Input: Text, pattern -> string
# Output: First index of text that matches pattern, -1 if no match -> int
def kmp_algo(text, pattern):
	i = 0
	j = 0

	# Case-insensitive comparison
	text = text.casefold()
	pattern = pattern.casefold()

	b = border_function(pattern)

	while (i < len(text)):
		if (text[i] == pattern[j]):
			if (j == len(pattern) - 1):
				return i - len(pattern) + 1
			i += 1
			j += 1
		elif (j > 0):
			j = b[j-1]
		else:
			i += 1

	return -1


# Pattern matching with Boyer-Moore Algorithm
# Input: Text, pattern -> string
# Output: First index of text that matches pattern, -1 if not match -> int
def bm_algo(text, pattern):
	i = len(pattern) - 1
	j = len(pattern) - 1

	# Case-insensitive comparison
	text = text.casefold()
	pattern = pattern.casefold()

	l = last_occurance(text, pattern)

	while (i < len(text)):
		if (text[i] == pattern[j]):
			if (j == 0):
				return i
			else:
				i -= 1
				j -= 1
		else:
			last_occ = l[text[i]]
			i = i + len(pattern) - min(j, 1 + last_occ)
			j = len(pattern) - 1

	return -1


#
# HELPER FUNCTIONS
#

# Calculate border function
# Input: pattern -> string
# Output: -> Array of integer
def border_function(pattern):
	b = [] 
	border = 0

	# First index of border must be 0
	b.append(0)

	# Border function
	for i in range(1, len(pattern) - 1):
		while (border != 0 and pattern[i] != pattern[border]):
			border = b[border - 1]
		if (pattern[i] == pattern[border]):
			border = border + 1
		else:
			border = 0
		b.append(border)

	return b


# Save index of last occurance per element in pattern with element from text
# Input: Text, pattern -> string
# Output: -> Dictionary
def last_occurance(text, pattern):
	l = dict()
	for element in text:
		l[element] = -1
	for i in range(len(pattern)):
		l[pattern[i]] = i

	return l


#
# MAIN
#
def main():
	text = "abacaabaccabacabaABb"
	pattern = "abACab"
	print("KMP: ")
	print(kmp_algo(text, pattern))
	print("BM: ")
	print(bm_algo(text, pattern))

	print(text)
	print(pattern)


if __name__ == '__main__':
	main()
