# DATABASES

forum:
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
        codeType (TINYTEXT, administrator / user, comes from code)

    articles:
        articleId (number, ticking up, MEDIUMINT, unsigned)
        userId (MEDIUMINT, unsigned)
        articleTitle (TEXT)
        articleText (formatet text, LONGTEXT)
        articleTags (used for search, JSON (array))
        articleCreated (timestamp)

    likes:
        likeId (number, ticking up, Double, unsigned)
        userId (number, ticking up, MEDIUMINT)
        articleId (number, ticking up, MEDIUMINT)
        likeCreated (timestamp)
    
    views:
        viewId (number, ticking up, Double, unsigned)
        userId (number, ticking up, MEDIUMINT, unsigned)
        articleId (number, ticking up, MEDIUMINT, unsigned)
        viewCreated (timestamp)

    codes:
        codeId (number, ticking up, MEDIUMINT, unsigned)
        codeName (string, TEXT)
        codeType (TINYTEXT, administrator / user)

Icons:
    <a href="https://icons8.com/icon/83195/menu">Menu icon by Icons8</a>



Administrator:
    Password: forum_admin
