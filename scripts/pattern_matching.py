#
# PATTERN MATCHING ALGORITHM
#

import re

# Pattern matching with KMP Algorithm
# Input: Text, pattern -> string
# Output: Array of string with [0] text before match, [1] matched text, [2] text after match. -1 if no match -> int
def kmp_algo(text, pattern, case_sensitive, whole_word):
	i = 0
	j = 0

	# Case-insensitive comparison
	if (not(case_sensitive)):
		text = text.casefold()
		pattern = pattern.casefold()

	b = border_function(pattern)

	while (i < len(text)):
		if (text[i] == pattern[j]):
			if (j == len(pattern) - 1):
				index = i - len(pattern) + 1
				if (not(whole_word) or wholeword_checker(index, text, len(pattern))):
					return [text[:index], text[index:(index+len(pattern))], text[index+len(pattern):]]
				else:
					return kmp_algo(text[index + 1:], pattern, case_sensitive, whole_word)
			i += 1
			j += 1
		elif (j > 0):
			j = b[j-1]
		else:
			i += 1

	return -1

# Pattern matching with Boyer-Moore Algorithm
# Input: Text, pattern -> string
# Output: Array of string with [0] text before match, [1] matched text, [2] text after match. -1 if no match -> int
def bm_algo(text, pattern, case_sensitive, whole_word):
	i = len(pattern) - 1
	j = len(pattern) - 1

	# Case-insensitive comparison
	if (not(case_sensitive)):
		text = text.casefold()
		pattern = pattern.casefold()

	l = last_occurance(text, pattern)

	while (i < len(text)):
		if (text[i] == pattern[j]):
			if (j == 0):
				if (not(whole_word) or wholeword_checker(i, text, len(pattern))):
					return [text[:i], text[i:(i+len(pattern))], text[i+len(pattern):]]
				else:
					return bm_algo(text[i + 1:], pattern, case_sensitive, whole_word)
			else:
				i -= 1
				j -= 1
		else:
			last_occ = l[text[i]]
			i = i + len(pattern) - min(j, 1 + last_occ)
			j = len(pattern) - 1

	return -1

def regex(text, pattern):
	regex = re.compile(pattern)
	matches = regex.findall(text) # Menemukan semua hasil pencarian
	# Apakah ada yang cocok?
	if regex.search(text) :
		matchespositions = [m.start() for m in regex.finditer(text)] # Array form
		if len(matches) == 1 :
			print("1 match found :", matchespositions)
		else :
			print(len(matches), "matches found :", matchespositions)
	else :
		matchespositions = []
		print("There is no match")
	return matchespositions

#
# HELPER FUNCTION
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

# Check whether word selected is whole (not substring of other word)
# Input: starting index of pattern -> int, text -> string, length of pattern -> int
# Output: -> Boolean
def wholeword_checker(index, text, length):
	if (index > 0):
		if (text[index - 1].isalnum()):
			return False
	if (index + length < len(text)):
		if (text[index + length].isalnum()):
			return False
	return True

#
# MAIN
#
def main():
	text = "ASdasda Check asdasd"
	pattern = "Check"
	print("KMP: ")
	print(kmp_algo(text, pattern, True, True))
	print("BM: ")
	print(bm_algo(text, pattern, True, True))
	print("Regex: ")
	print(regex(text, pattern))
	print(text)
	print(pattern)

	# UNTUK REGEX USER DEFINED
	print()
	print(" ****** USER DEFINED REGEX *****")
	print()
	# COBA INPUT (\w+):(\w+):(\d+)
	pattern = input("Input Regular Expressions : ")
	print()
	text = 'apple:green:3 banana:yellow:5 heyy zka'
	regexresult = regex(text, pattern)
	print(regexresult)

if __name__ == '__main__':
	main()