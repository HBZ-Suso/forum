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

11. passwordChanges:
    1. passwordChangeId (BIGINT, UNSIGNED, ticking up, unsigned)
    2. passwordChangeUserId (MEDIUMINT, UNSIGNED)
    3. passwordChangeIp (LONGTEXT)
    4. passwordChangeDate (LONGTEXT, UNIX TIMESTAMP)

12. visitDetails:
    1. visitId (BIGINT, UNSIGNED, ticking up)
    2. userId (TEXT, "false" if not logged in)
    3. visitIp (LONGTEXT)
    4. visitDate (BIGINT, UNIX TIMESTAMP)
    5. visitPage (LONGTEXT)
    6. visitData (LONGTEXT, json of $rargs)
    7. visitUserAgent (LONGTEXT, json)
    8. visitBrowser (LONGTEXT, json, output of get_browser)

13. reports:
    1. reportId (BIGINT, UNSIGNED, ticking up)
    2. reportTitle (TEXT)
    3. reportText (LONGTEXT)
    4. reportDate (BIGINT, UNIX TIMESTAMP, unsigned)
    5. reportIp (LONGTEXT)
    6. userId (TEXT, "false" if not logged in)

14. links:
    1. linkId (BIGINT, unsigned, ticking up)
    2. linkPassword (LONGTEXT, random code for authentification)
    3. userId (MEDIUMINT, unsigned)
    4. linkCreated (BIGINT, UNIX TIMESTAMP, unsigned)
    5. linkInfo (LONGTEXT)

15. errors:
    1. errorId (u BIGINT, ticking up)
    2. errorName (TEXT)
    3. errorDate (BIGINT, UNIX TIMESTAMP, unsigned)
    4. errorIp (LONGTEXT)
    5. userId (TEXT, "false" if not logged in)
    6. errorFile (TEXT)

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

Icons:
    <a href="https://icons8.com/icon/83195/menu">Menu icon by Icons8</a>
    <a href="https://icons8.com/icon/DFU1kReSUccu/heart">Heart icon by Icons8</a>
    <a href="https://icons8.com/icon/83214/settings">Settings icon by Icons8</a>
    <a href="https://icons8.com/icon/70738/drop-down">Drop Down icon by Icons8</a>
    <a href="https://icons8.com/icon/AqDEb8mCIrk9/macos-close">MacOS Close icon by Icons8</a>
    <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>

Administrator:
    Password: forum_admin

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
