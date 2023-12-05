import re
import csv
import matplotlib.pyplot as plt
from datetime import datetime

def extractipaddress(fname):
    with open(fname,"r") as access_log:
        ourlist = []
        for x in access_log:
            if("djovanoska" in x):
                ourlist.append(x)
        ourlist = ''.join(ourlist)
        regexp = r'\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}'
        ips_list = re.findall(regexp, ourlist)
    access_log.close() 
    return(ips_list)

def extracttimestamps(fname):
    with open(fname,"r") as access_log:
        ourlist = []
        for x in access_log:
            if("djovanoska" in x):
                ourlist.append(x)
        ourlist = ''.join(ourlist)
        regexp = r"(?<=\[)(.*?)(?=\])"
        time_list = re.findall(regexp, ourlist)
    access_log.close() #close file     
    print("Ip addresses:")  
    print(time_list)  
    return(time_list)

def readerlogs(fname):
    with open(fname,"r") as access_log:
        ourlist = []
        for x in access_log:
            if("djovanoska" in x):
                ourlist.append(x)
        ourlist = ''.join(ourlist)
        regexp = r"(?<=POST )|(?<=GET ).*?(?= HTTP)"
        time_list = re.findall(regexp, ourlist)
    access_log.close() #close file     
    print("Ip addresses:")  
    print(time_list)  
    return(time_list)

def extractbrowserdetails(fname):
    with open(fname,"r") as access_log:
        ourlist = []
        for x in access_log:
            if("djovanoska" in x):
                ourlist.append(x)
        ourlist = ''.join(ourlist)
        regexp = r"(?<=\" \").*(?=\")"
        ips_list = re.findall(regexp, ourlist)
    access_log.close() #close file     
    print("Ip addresses:")  
    print(ips_list)  
    return(ips_list)

def writetologfile(iplist, timestamps, requestsender ,browserinfo):
    with open("access_log.csv", "w") as output:
        writer = csv.writer(output)
        header = ["IP Address", "Timestamp", "Request type", "Browser info"]
        writer.writerow(header)
        for x in range(0, len(requestsender)):
            writer.writerow((iplist[x], timestamps[x], requestsender[x], browserinfo[x]))
    output.close()
    print("Write Successful...")

def create_access_timeline(timestamps):
    timestamps = [datetime.strptime(ts, "%d/%b/%Y:%H:%M:%S %z") for ts in timestamps]

    plt.figure(figsize=(10, 6))
    plt.plot(timestamps, range(len(timestamps)), marker='o', linestyle='-', color='green')
    plt.xlabel('Timestamp')
    plt.ylabel('Access Occurrences')
    plt.title('Access Occurrences Timeline')
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.savefig('access_timeline.pdf')
    print("Plot saved as access_timeline.pdf")

if __name__ == '__main__':
    log_file_path = '/var/log/apache2/access_log'
    ips = extractipaddress(log_file_path)
    timestamps = extracttimestamps(log_file_path)
    requests = readerlogs(log_file_path)
    browsers = extractbrowserdetails(log_file_path)

    writetologfile(ips, timestamps, requests, browsers)

    create_access_timeline(timestamps)