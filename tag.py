import subprocess
import sys

INCREMENTS = {
	"patch": 2,
	"minor": 1,
	"major": 0,
}

def main():
	increment = sys.argv[-1]
	if increment not in ['patch', 'minor', 'major']:
		print 'Invalid INCREMENT value. Please use "patch", "minor", or "major".'
		os.Exit(1)

	increment = INCREMENTS[increment] 

	current = subprocess.check_output("git describe", shell=True).strip()
	last_stable = subprocess.check_output("git tag -l", shell=True).strip().split('\n')[-1]
	if current == last_stable:
		return

	last_stable_split = last_stable.split('.')
	last_stable_split[increment] = str(int(last_stable_split[increment]) + 1)
	
	if increment == 0:
		last_stable_split[1] = "0"
		last_stable_split[2] = "0"

	if increment == 1:
		last_stable_split[2] = "0"

	incremented = '.'.join(last_stable_split)
	print incremented

	replace_in_file('src/Version.php', last_stable, incremented)

	subprocess.check_call('git add src/Version.php', shell=True)
	subprocess.check_call('git commit -m "Incremented version number to {0}"'.format(incremented), shell=True)
	subprocess.check_call('git tag -a {0} -m "{0}"'.format(incremented), shell=True)
	subprocess.check_call('git push origin master --tags', shell=True)


def replace_in_file(filename, search, replace):
	with open(filename) as source:
		updated = source.read().replace(search, replace)

	with open(filename, 'w') as update:
		update.write(updated)


if __name__ == '__main__':
	main()
