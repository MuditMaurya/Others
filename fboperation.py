#Script to open Facebook in google Chrome
import sys
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import getpass
name=raw_input("Enter Your Facebook Login User Name")
password=getpass.getpass()
driver = webdriver.Chrome('/home/mpmaurya/Documents/Project/SCDownloader/chromedriver')
driver.get("http://www.facebook.com")
url=driver.find_element_by_id("email")
url.send_keys(name)
url1=driver.find_element_by_id("pass")
url1.send_keys(password)
driver.find_element_by_id("loginbutton").click()
