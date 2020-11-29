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
    14. userLastArticle (UNIX Timestamp, at first unix timestamp of creation, then last article time)

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


5. userLikes:
    1. likeId (number, ticking up, Double, unsigned)
    2. userId (number, ticking up, MEDIUMINT)
    3. targetUserId (number, ticking up, MEDIUMINT)
    4. likeCreated (timestamp)

6. userViews:
    1. viewId (number, ticking up, Double, unsigned)
    2. userId (number, ticking up, MEDIUMINT, unsigned)
    3. targetUserId (number, ticking up, MEDIUMINT, unsigned)
    4. viewCreated (timestamp)

7. codes:
    1. codeId (number, ticking up, MEDIUMINT, unsigned)
    2. codeName (string, TEXT)
    3. codeType (TINYTEXT, administrator / user)
    4. codeIntendet (TINYTEXT, discribes intendation of code)

Icons:
    <a href="https://icons8.com/icon/83195/menu">Menu icon by Icons8</a>

Administrator:
    Password: forum_admin

layers:
    frame: 2
    menu: 3
