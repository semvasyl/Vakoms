# Vakoms

###samples
####view all articles (or only for specific user)
* http://study2.test/index.php?action=view&user=1 ```web```
* php index.php --viewAll --id=2 ```cli```

####view specific article with sorted comments
* http://study2.test/index.php?action=viewArticle&id=1 ```web```
* php index.php --view --id=1 ```cli```

####add comment
* http://study2.test/index.php?action=addComment  ```web```
* php index.php --addComment --id=1 --text="loremoto ipsumicus dolcenorica" ```cli```