# DATABASES

Database name: forum

users:
    userId (number, ticking up, MEDIUMINT, unsigned)
    userName (TEXT)
    userPassword (hash, LONGTEXT)
    userAge (TINYINT, unsigned)
    userEmployment (MEDIUMTEXT)
    userDescription (formatet text, LONGTEXT)
    userCreated (timestamp)
    userMail (TEXT)
    userPhone (TEXT)
    userSettings (JSON)
    userType (TINYTEXT, administrator / user, comes from code)
    userIntended (TINYTEXT, from codeIntended)
    userVerified (TINYTEXT, "TRUE" or "FALSE")
    userLastArticle (UNIX Timestamp, at first unix timestamp of creation, then last article time)

articles:
    articleId (number, ticking up, MEDIUMINT, unsigned)
    userId (MEDIUMINT, unsigned)
    articleTitle (TEXT)
    articleText (formatet text, LONGTEXT)
    articleTags (used for search, JSON (array))
    articleCreated (timestamp)

articleLikes:
    likeId (number, ticking up, Double, unsigned)
    userId (number, ticking up, MEDIUMINT)
    articleId (number, ticking up, MEDIUMINT)
    likeCreated (timestamp)

articleViews:
    viewId (number, ticking up, Double, unsigned)
    userId (number, ticking up, MEDIUMINT, unsigned)
    articleId (number, ticking up, MEDIUMINT, unsigned)
    viewCreated (timestamp)


userLikes:
    likeId (number, ticking up, Double, unsigned)
    userId (number, ticking up, MEDIUMINT)
    targetUserId (number, ticking up, MEDIUMINT)
    likeCreated (timestamp)

userViews:
    viewId (number, ticking up, Double, unsigned)
    userId (number, ticking up, MEDIUMINT, unsigned)
    targetUserId (number, ticking up, MEDIUMINT, unsigned)
    viewCreated (timestamp)

codes:
    codeId (number, ticking up, MEDIUMINT, unsigned)
    codeName (string, TEXT)
    codeType (TINYTEXT, administrator / user)
    codeIntendet (TINYTEXT, discribes intendation of code)

Icons:
    <a href="https://icons8.com/icon/83195/menu">Menu icon by Icons8</a>



Administrator:
    Password: forum_admin



layers: 
    frame: 2
    menu: 3