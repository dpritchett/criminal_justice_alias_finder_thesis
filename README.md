# tl;dr: Skip to [/include/doSearch.php](http://github.com/dpritchett/criminal_justice_alias_finder_thesis/blob/master/include/doSearch.php) to see the meat

# Project history and discussion of lessons learned since 2005

This source code was written in 2004 and 2005 by [Daniel J. Pritchett](http://www.sharingatwork.com) in support of a thesis for a Master's in Computer Science from the University of Alabama.  [Click here for the paper in PDF form](https://docs.google.com/leaf?id=0B4mDL5-uI4G3YjBlMGE3NDgtNTcwMy00MjU4LThhZjItYjk3YTJlOTBhMDVk&sort=name&layout=list&num=50).

The tools used are PHP and MySQL - the 2005 stable versions.  Databases were hosted on Windows XP Professional workstations in a university computer lab.

A quick perusal of the code will reveal a naive lack of XHTML compliance, any sort of CSS, source control, and robust test automation.

I have learned a lot about software engineering since then and I'm currently revisiting PHP (and Clojure and several other technologies).  Follow along on [my Posterous blog](http://dpritchett.posterous.com) or here on github if you're curious.

_Daniel_

# Project overview reprinted from thesis first draft:
The goals of this experiment: To create a sample web application that allows the user to perform custom queries on a federated criminal justice database, to identify and analyze applicable data de-duplication methods, to document the decision-making process involved in creating the system, and to produce a system template that can be readily adapted to fit other needs.  To that end, the system design will be as affordable as possible.

A central web application server queries 4 separate database servers.  The results of these queries are formatted and returned to the user.  The data represented here will be driver.s license type data:  First name, last name, sex, height, weight, driver.s license number, etc.  Users of the system are expected to give approximate values for one or more of the driver.s license attributes, and the system returns a list of possible matches.  Effort will be made to find hits that are similar to the query even if they do not match perfectly.  Further, the system will attempt to distill each person down to a single expandable entry in cases where a suspect has more than one entry (such as multiple arrest records in a prison database).
