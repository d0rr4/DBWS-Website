import csv
import re
import matplotlib.pyplot as plt
from datetime import datetime

def error_reader(filename):
    with open(filename, "r") as error_log:
        ourlist = []
        for x in error_log:
            if("djovanoska" in x):
                ourlist.append(x)

        ourlist = ''.join(ourlist) 
        regexp = r"(?<=\[)(.*?)(?=\])"
        errordata = re.findall(regexp, ourlist)
        return(errordata)

def write_csv(errorlist):
    with open('error_log.csv', 'w') as csvfile:
        writer = csv.writer(csvfile)
        header = ['timestamp ', 'error ', 'pid ', 'requestby ']
        writer.writerow(header)
        count =  0
        for item in errorlist:
            if count == 0:
                time = item
                count += 1
            elif count == 1:
                type = item
                count +=1
            elif count == 2:
                pid = item
                count +=1
            elif count == 3:
                client = item
                writer.writerow((time, type, pid, client))
                count = 0

    print("Write Successful...")

def create_error_timeline(errorlist):
    timestamps = errorlist[::4]
    timestamps = [datetime.strptime(ts, "%a %b %d %H:%M:%S.%f %Y") for ts in timestamps]

    plt.figure(figsize=(10, 6))
    plt.plot(timestamps, range(len(timestamps)), marker='o', linestyle='-', color='red')
    plt.xlabel('Timestamp')
    plt.ylabel('Error Occurrences')
    plt.title('Error Occurrences Timeline')
    plt.xticks(rotation=45)
    plt.tight_layout()
    # plt.show()
    plt.savefig('error_timeline.pdf')
    print("Plot saved as error_timeline.pdf")

if __name__ == "__main__":
    error_list = error_reader('/var/log/apache2/error_log')
    write_csv(error_list)

    create_error_timeline(error_list)