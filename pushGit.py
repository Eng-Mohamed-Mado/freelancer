import os
import time

def initialize_repository(commit_message="Initial commit"):
    if not os.path.isdir('.git'):
        print("Initializing a new Git repository...")
        os.system('git init')
        os.system('git add .')
        os.system(f'git commit -m "{commit_message}"')

def set_repository_url():
    if not os.popen('git remote get-url origin').read():
        repository_url = input("Please provide the repository URL: ")
        os.system(f'git remote add origin {repository_url}')

def commit_and_push():
    os.system('git add .')

    # Prompt the user for a commit message
    commit_message = input("Please enter the commit message: ")
    
    os.system(f'git commit -m "{commit_message}"')
    os.system('git branch -M main')

    # Push the changes to the repository
    os.system('git push origin main')

    # If push fails, force push
    if os.system('git push origin main') != 0:
        os.system('git push origin main --force')

# Pass your desired initial commit message here
initialize_repository(commit_message="Custom initial commit")
set_repository_url()

while True:
    commit_and_push()
    time.sleep(1800)
