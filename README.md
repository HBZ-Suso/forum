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
    10. userSettings (JSON)
    11. userType (TINYTEXT, administrator / user, comes from code)
    12. userIntended (TINYTEXT, from codeIntended)
    13. userVerified (TINYTEXT, "TRUE" or "FALSE")
    14. userLastArticle (UNIX Timestamp, at first unix timestamp of creation, then last article time, UNSIGNED INT)
    15. userLastComment (UNIX Timestamp, at first unix timestamp of creation, then last comment time, UNSIGEND INT)

2. articles:
    1. articleId (number, ticking up, MEDIUMINT, unsigned)
    2. userId (MEDIUMINT, unsigned)
    3. articleTitle (TEXT)
    4. articleText (formatet text, LONGTEXT)
    5. articleTags (used for search, JSON (array))
    6. articleCreated (timestamp)

3. articleLikes:
    1. likeId (number, ticking up, Double, unsigned)
    2. userId (number, ticking up, MEDIUMINT)
    3. articleId (number, ticking up, MEDIUMINT)
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
    1. likeId (number, ticking up, Double, unsigned)
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
    3. codeType (TINYTEXT, administrator / user)
    4. codeIntendet (TINYTEXT, discribes intendation of code)

10. collaborators:
    1. collaboratorId (MEDIUMINT, ticking up, unsigned)
    2. collaboratorName (MEDIUMTEXT)
    3. collaboratorLore (LONGTEXT)
    4. collaboratorDescription (LONGTEXT)
    5. collaboratorLink (LONGTEXT)

Icons:
    <a href="https://icons8.com/icon/83195/menu">Menu icon by Icons8</a>
    <a href="https://icons8.com/icon/DFU1kReSUccu/heart">Heart icon by Icons8</a>

Administrator:
    Password: forum_admin

layers:
    frame: 2
    menu: 3
    loading-background: 4
    script-warning: 6
    theme-switcher: 2
    refined search popout: 4
    about-collaborator: 0
    about-collaborator on clicked: 1

GITHUB: github.com/HBZ-Suso/forum
