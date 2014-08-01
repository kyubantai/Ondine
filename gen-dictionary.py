#!/usr/bin/env python
import os



# Main variables
generatedPath = './res/generated/'
generatedFile = 'dictionary.json'
modPath = './src/Ondine/Mod/'




# Check if dictionary path exists
# If not, creates it
def checkGeneratedDir():
	if not os.path.exists(generatedPath): 
		print ''
		print '[INFO] Directory ' + generatedPath + ' doesn\'t exists'
		os.makedirs(generatedPath)
		print '[INFO] Created directory ' + generatedPath


# Read all folders contained in
# the mod path.
def readMods():
	mods = []

	if not os.path.isdir(modPath):
		raise Exception(modPath + ' does not exist')

	for dirname in os.listdir(modPath):
		path = os.path.join(modPath, dirname)
		if os.path.isdir(path) and not dirname[0] == '.':
			mods.append(dirname)

	return mods


# Read the specified dictionary
def getDictionary(path):
	f = open(path)
	lines = f.read()
	f.close()

	return lines


# Convert list dictionary to a JSON string
def DictionaryToJSON(dictionary):
	_string = ""

	for mod in dictionary:
		string = '"' + mod + '": ' + dictionary[mod] + ' ,'
		_string += string

	return '{' + _string[:-1] + '}'


# Write the dictionary in a file
def writeInDictionary(content):
	checkGeneratedDir()

	path = os.path.join(generatedPath, generatedFile)

	print ''
	print '[INFO] Generating main dictionary...'

	f = open(path, 'w')
	f.write(content)
	f.close()

	print ''
	print '[INFO] -------------------------------'
	print '[INFO] Main dictionary created successfully'
	print '[INFO] -------------------------------'


# Main function
def generateDictionary():
	print '[INFO] -------------------------------'
	print '[INFO] Starting process'
	print '[INFO] -------------------------------'
	print ''

	dictionary = {}
	mods = readMods()

	for mod in mods:
		dictionaryPath = os.path.join(modPath, mod, 'dictionary.json')

		if os.path.isfile(dictionaryPath):
			print '[INFO] Read dictionary of ' + mod
			dictionary[mod] = getDictionary(dictionaryPath)
		else:
			print '[WARN] No dictionary for ' + dictionaryPath


	print ''
	print '[INFO] Loaded ' + `len(dictionary)` + ' dictionaries'

	json = DictionaryToJSON(dictionary)
	writeInDictionary(json)


# Execute process
generateDictionary()