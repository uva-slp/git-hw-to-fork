#A groupme bot that posts the entire contents of script.txt line by line.


import requests
from time import sleep
#put the id of the bot you created at dev.groupme.com here, then run with "python script.py"
BOT_ID = ''
SCRIPT_FILE = 'script.txt'

def send_script(filename):
    script = ''
    data = {'bot_id': BOT_ID,
            'text': script}
    with open(filename, 'r') as f:
        for line in f:
            if line.strip():
                if line.strip()[-1] not in ['.', '!', '?']:
                    script += line.strip() + ' '
                else:
                    script += line
                    data['text'] = script
                    r = requests.post('https://api.groupme.com/v3/bots/post', json=data)
                    script = ''
                    sleep(10)
    data['text'] = script
    r = requests.post('https://api.groupme.com/v3/bots/post', json=data)
    print(r.json())


def main():
    send_script(SCRIPT_FILE)


if __name__ == '__main__':
    main()
