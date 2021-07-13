# DATABASES

Database name: forum

1. users:
    1. userId (number, ticking up, MEDIUMINT, unsigned)
    2. userName (TEXT)
    3. userPassword (hash, LONGTEXT)
    4. userAge (TINYINT, unsigned)
    5. userEmployment (MEDIUMTEXT)
    6. userDescription (formatet text, LONGTEXT)
    7. userCreated (timestamp)
    8. userMail (TEXT)
    9. userPhone (TEXT)
    10. userSettings (JSON, color (red, pruple, pink, green, yellow, black, blue, turquoise) privacy (notifications, 2=everything, 1=improtant, 0=nothing), public (displayed, true=public, false=hidden [NOT IMPLEMENTED]))
    11. userType (TEXT, administrator / user / moderator, comes from code)
    12. userIntended (TINYTEXT, from codeIntended)
    13. userVerified (TINYINT / BOOLEAN, 1 or 0)
    14. userLastArticle (UNIX Timestamp, at first unix timestamp of creation, then last article time, UNSIGNED Double)
    15. userLastComment (UNIX Timestamp, at first unix timestamp of creation, then last comment time, UNSIGEND Double)
    16. userLocked (UNSIGNED TINYINT, 1 for true or 0 for false)

2. articles:
    1. articleId (number, ticking up, MEDIUMINT, unsigned)
    2. userId (MEDIUMINT, unsigned)
    3. articleTitle (TEXT)
    4. articleText (formatet text, LONGTEXT)
    5. articleTags (used for search, JSON (array))
    6. articleCreated (timestamp, CURRENT_TIMESTAMP)
    7. articleCategory ("Home", "About", "Discussion", "Projects", "Help", TEXT)
    8. articlePinned (UNSIGNED TINYINT, 1 for true or 0 for false)

3. articleLikes:
    1. likeId (number, ticking up, DOUBLEINT, unsigned)
    2. userId (number,  MEDIUMINT)
    3. articleId (number, MEDIUMINT)
    4. likeCreated (timestamp)

4. articleViews:
    1. viewId (number, ticking up, Double, unsigned)
    2. userId (number, ticking up, MEDIUMINT, unsigned)
    3. articleId (number, ticking up, MEDIUMINT, unsigned)
    4. viewCreated (timestamp)

5. articleComments:
    1. commentId (DOUBLE, unsigned, AI)
    2. userId (MEDIUMINT)
    3. articleId (MEDIUMINT)
    4. commentTitle (MEDIUMTEXT)
    5. commentText (LONGTEXT)
    6. commentCreated (TIMESTAMP)

6. userLikes:
    1. likeId (number, ticking up, DOUBLEINT, unsigned)
    2. userId (number, ticking up, MEDIUMINT)
    3. targetUserId (number, ticking up, MEDIUMINT)
    4. likeCreated (timestamp)

7. userViews:
    1. viewId (number, ticking up, Double, unsigned)
    2. userId (number, ticking up, MEDIUMINT, unsigned)
    3. targetUserId (number, ticking up, MEDIUMINT, unsigned)
    4. viewCreated (timestamp)

8. userComments:
    1. commentId (DOUBLE, unsigned, AI)
    2. userId (MEDIUMINT)
    3. targetUserId (MEDIUMINT)
    4. commentTitle (MEDIUMTEXT)
    5. commentText (LONGTEXT)
    6. commentCreated (TIMESTAMP)

9. codes:
    1. codeId (number, ticking up, MEDIUMINT, unsigned)
    2. codeName (string, TEXT)
    3. codeType (TEXT, administrator / user/ moderator)
    4. codeIntended (TEXT, discribes intendation of code)

10. collaborators:
    1. collaboratorId (MEDIUMINT, ticking up, unsigned)
    2. collaboratorName (MEDIUMTEXT)
    3. collaboratorLore (LONGTEXT)
    4. collaboratorDescription (LONGTEXT)
    5. collaboratorLink (LONGTEXT)

11. settingChanges:
    1. settingChangeId (BIGINT, UNSIGNED, ticking up, unsigned)
    2. matchId
    3. settingChangeType (TEXT, Setting Name)
    4. settingChangeFrom (LONGTEXT, Before)
    5. settingChangeTo (LONGTEXT, After)
    6. settingChangeDate (u BIGINT, UNIX TIMESTAMP)

12. visits:
    1. visitId (BIGINT, UNSIGNED, ticking up)
    2. matchKey (MEDIUMINT)
    3. visitDate (BIGINT, UNIX TIMESTAMP)
    4. visitPage (LONGTEXT)
    5. visitData (LONGTEXT, json of $rargs)

13. reports:
    1. reportId (BIGINT, UNSIGNED, ticking up)
    2. matchId (MEDIUMINT)
    3. reportTitle (TEXT)
    4. reportText (LONGTEXT)
    5. reportDate (BIGINT, UNIX TIMESTAMP, unsigned)

14. links:
    1. linkId (BIGINT, unsigned, ticking up)
    2. linkPassword (LONGTEXT, random code for authentification)
    3. userId (MEDIUMINT, unsigned)
    4. linkCreated (BIGINT, UNIX TIMESTAMP, unsigned)
    5. linkInfo (LONGTEXT)

15. errors:
    1. errorId (u BIGINT, ticking up)
    2. matchId (MEDIUMINT)
    3. errorName (TEXT)
    4. errorDate (BIGINT, UNIX TIMESTAMP, unsigned)
    5. errorFile (TEXT)

16. archivedArticles:
    1. archivedArticleId (MEDIUMINT, unsigned, ticking up)
    2. articleId (MEDIUMINT, unsigned)
    3. userId (MEDIUMINT, unsigned)
    4. articleTitle (TEXT)
    5. articleText (formatet text, LONGTEXT)
    6. articleTags (used for search, JSON (array))
    7. articleCreated (timestamp)
    8. articleCategory ("Home", "About", "Discussion", "Projects", "Help", TEXT)
    9. articlePinned (UNSIGNED TINYINT, 1 for true or 0 for false)
    10. articleArchived (timestamp, CURRENT_TIMESTAMP)

17. notifications:
    1. notificationId (u BIGINT, ticking up)
    2. userId (u MEDIUMINT, user the notification is for)
    3. notificationType (u TINYINT, 0 = article Liked, 1 = Profile Liked, 2 = articleCommented, 3 = profileCommented, 4 = liked Profile has posted an Article, 5 = Settings changed, 6 = password changed, 7 = linked, 8 = verified, 9 = locked, 10 = resetpassword, 11 = published article, 12 = account unlocked, 13 = account created, 14 = Report sent, 15 = article Deleted, 16 = articlePinned, 17. messaged)
    4. notificationDate (u BIGINT, UNIX TIMESTAMP)
    5. notificationRead (u TINYINT, 0 for false 1 for true)
    6. notificationLink (LONGTEXT, url without hostname to notification target, "-|-openchat**${userId}-|-")
    7. notificationDescription (LONGTEXT, descriptive Text)

18. logs:
    1. logId (u BIGINT)
    2. matchId (MEDIUMINT)
    3. logType (TEXT, "logs")
    4. logContent (LONGTEXT, JSON, depends on logType)
    5. logDate (u BIGINT, UNIX TIMESTAMP)

19. matches:
    1. matchId (u BIGINT, ticking up)
    2. matchId (u BIGINT)
    3. matchIp (TEXT)
    4. matchBrowser (LONGTEXT)
    5. userId (TEXT, false if not logged in)
    6. matchDate (u BIGINT, UNIX TIMESTAMP)
    7. matchType (u TINYINT, 0 = none, 1 = Ip and Browser, 2 = userId, 3 = fingerprint)
    8. matchUserAgent (LONGTEXT, json)
    9. matchHttpLanguage (TEXT)
    10. matchFingerprint (TEXT, fingerprint)
    11. matchLatestDate (u BIGINT, UNIX TIMESTAMP)

20. messages:
    1. messageId (u BIGINT, autoincr)
    2. messageFrom (u MEDIUMINT, userId)
    3. messageTo (u MEDIUMINT, userId)
    4. messageDate (u BIGINT, UNIX TIMESTAMP)
    5. messageText (LONGTEXT, messageText)
    6. messageRead (u TINYINT, 0 = false, 1 = true)



Icons:
    <a href="https://icons8.com/icon/83195/menu">Menu icon by Icons8</a>
    <a href="https://icons8.com/icon/DFU1kReSUccu/heart">Heart icon by Icons8</a>
    <a href="https://icons8.com/icon/83214/settings">Settings icon by Icons8</a>
    <a href="https://icons8.com/icon/70738/drop-down">Drop Down icon by Icons8</a>
    <a href="https://icons8.com/icon/AqDEb8mCIrk9/macos-close">MacOS Close icon by Icons8</a>
    <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>

Administrator:
    Password: !23forum_admin32!

layers:
    frame: 2
    menu: 3
    loading-background: 4
    script-warning: 6
    theme-switcher: 2
    refined search popout: 1
    about-collaborator: 0
    about-collaborator on clicked: 1
    custum prompt: 6
    custom prompt enter: 7
    verify & like btns: 2

GITHUB: github.com/HBZ-Suso/forum

For notifications:
    Codes are:
        1. {{liked}} = " liked ", Example: "NathanZumbusch" {{liked}} "Das Kopfrechenprojekt"
        2. {{commented}} = " commented on ", Example: "NathanZumbusch" {{commented}} "Das Kopfrechenprojekt"
        3. {{commentedProfile}} = " commented on your profile.", Example: "NathanZumbusch" {{commented}}
        4. {{posted}} = " posted ", Example: "NathanZumbusch" {{posted}} "Das Kopfrechenprojekt
        5. {{settingschanged}} = "-setting was changed.", Example: {{settingschanged}}
        6. {{passwordchanged}} = "You changed your password.", Example: {{passwordchanged}}
        7. {{verified}} = "Your account got verified.", Example: {{verified}}
        8. {{locked}} = "Your account got locked. ", Example: {{Locked}}
        9. {{passwordreset}} = "Your password got reset, check your mails. ", Example: {{passwordreset}}
        10. {{publishedarticle1}} = "Your article "
        11. {{publishedarticle2}} = " was just published."
        12. {{unlocked}} = "Your account was just unlocked"
        13. {{accountcreated}} = "Your account was successfully created. Enjoy yourself!"
        14. {{reportsent}} = "Your report was successfully sent."
        15. {{articledeleted}} = " was successfully deleted."
        16. {{notification}} = "Notification",
        17. {{public}} = "Public",
        18. {{pinned}} = " was pinned."
        19. {{messaged}} = " messaged you."
    Use them in order for them to be replaced by translations.
