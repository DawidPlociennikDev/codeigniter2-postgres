## Codeigniter 2 with PostgreSQL (PHP 7.4)

Clone project

```bash
  https://github.com/DawidPlociennikDev/codeigniter2-postgres.git
```

Build docker

```bash
  docker-compose build
```

Run docker containers

```bash
  docker-compose up
```

Install composer dependencies

```bash
  docker-compose exec web composer install
```

Run migrations
[http://localhost:8080/migrate](http://localhost:8080/migrate)

Seed database
[http://localhost:8080/migrate/seed](http://localhost:8080/migrate/seed)

Project
[http://localhost:8080](http://localhost:8080)

Admin
[http://localhost:8080/logowanie](http://localhost:8080/logowanie)

Adminer
[http://localhost:8081](http://localhost:8081/?)

SOLR
[http://localhost:8983/solr](http://localhost:8983/solr)



Run PHPStan

```bash
  vendor/bin/phpstan analyse -c phpstan.neon
```

Run PHPCS

```bash
  phpcs application
```

Init GrumPHP before commit

```bash
  ./vendor/bin/grumphp git:init
```

## REST API

GET ALL COMMENTS
[http://localhost:8080/migrate](http://localhost:8080/api/get)

GET ONE COMMENT BY ID
[http://localhost:8080/migrate](http://localhost:8080/api/get/{$id})

PUT COMMENT
[http://localhost:8080/migrate](http://localhost:8080/api/put/{$id})

PATCH COMMENT
[http://localhost:8080/migrate](http://localhost:8080/api/patch/{$id})

POST COMMENT
[http://localhost:8080/migrate](http://localhost:8080/api/post)

DELETE COMMENT
[http://localhost:8080/api/delete/{$id}](http://localhost:8080/api/delete/{$id})

## Apache SOLR

Install on Ubuntu 22.04
[https://solr.apache.org/guide/solr/latest/deployment-guide/installing-solr.html](https://solr.apache.org/guide/solr/latest/deployment-guide/installing-solr.html)

Get documents

```bash
  curl http://localhost:8983/solr/{index}/select\?q\=\*:\*
```

Create a solr core with default configs

```bash
   curl -X GET 'http://localhost:8983/solr/admin/cores?action=create&name={core_name}&instanceDir=configsets/{core_name}'
```

Get current schema fields

```bash
   curl -X GET 'http://localhost:8983/solr/{core_name}/schema/fields'
```

Add document to solr

```bash
   curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/{core_name}/update' --data-binary '
    {
      "add": {
        "doc": {
            "content":"Late night with Solr 8.5",
            "likes":10
      }
      }
    }'
```

Delete a collection

```bash
  curl -X GET 'http://localhost:8983/solr/admin/cores?action=UNLOAD&core={core_name}&deleteInstanceDir=true&deleteDataDir=true'
```

Add new field in solr, explicitly --data-binary - This posts data exactly as specified with no extra processing whatsoever.

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-field":{
      "name":"updated_on",
      "type":"pdate",
      "indexed":true }
  }' http://localhost:8983/api/cores/{core_name}/schema
```

Replace field

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "replace-field":{
      "name":"updated_on",
      "type":"plong",
      "indexed":false }
  }' http://localhost:8983/api/cores/{core_name}/schema
```

Add a document without unique key

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/{core_name}/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
          "content":"test"
    }
    }
  }'
```

Get all documents from the index

```bash
  curl -X GET 'http://localhost:8983/solr/{core_name}/select?q=*:*'
```

Add a document with unique key to solr

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/{core_name}/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
        "id":"1",
        "content":"test"
    }
    }
  }'
```

Manualy change managed-schema

```bash
  nano server/solr/configsets/{core_name}/conf/managed-schema.xml 
```

Realod a collection

```bash
  curl -X GET "http://localhost:8983/solr/admin/cores?action=RELOAD&core={core_name}"
```

## Apache SOLR - course

Replace definition of a field 

```bash
curl -X POST -H 'Content-type:application/json' --data-binary '{
  "replace-field":{
     "name":"updated_on",
     "type":"pdate",
     "indexed":true }
}' http://localhost:8983/api/cores/search_twitter/schema
```

Add document to solr

```bash
curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
{
  "add": {
    "doc": {
        "twitter_id":"2",
        "updated_on":"2020-04-13T15:26:37Z"
	}
  }
}'
```

Get documents which were updated after date
```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=updated_on:\[2020-04-13T15:26:47Z%20TO%20*\]"
```

Add a new field in solr, explicitly
--data-binary - This posts data exactly as specified with no extra processing whatsoever.

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-field":{
      "name":"indexed_on",
      "type":"pdate",
      "indexed":false,
      "docValues":"false" }
  }' http://localhost:8983/api/cores/search_twitter/schema
```

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
          "twitter_id":"3",
          "indexed_on":"2020-04-13T15:26:47Z"
    }
    }
  }'
```

Get documents which were indexed after date

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=indexed_on:\[2020-04-13T15:26:47Z%20TO%20*\]"
```

Get all documents from the index

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=*:*"
```

Add a new field which is not searchable

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-field":{
      "name":"likes_count",
      "type":"pint",
      "indexed":false,
      "stored":true
      "docValues":false}
  }' http://localhost:8983/api/cores/search_twitter/schema
```

Add a new field in solr, explicitly

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-field":{
      "name":"user_name",
      "type":"string",
      "indexed":true,
      "stored":true}
  }' http://localhost:8983/api/cores/search_twitter/schema
```

Add a new field in solr, explicitly

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-field":{
      "name":"lang",
      "type":"string",
      "indexed":true,
      "stored":false,
    "docValues":false}
  }' http://localhost:8983/api/cores/search_twitter/schema
```

Add document to solr

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
          "twitter_id":"4",
          "user_name":"John",
          "lang":"eng",
          "content":"Happy searching!",
          "likes_count":10
    }
    }
  }'
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=user_name:John"
```
```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=lang:eng"
```
```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=likes_count:10"
```

Add a multiValue field

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-field":{
      "name":"links",
      "type":"text_general",
      "indexed":true,
      "stored":true,
      "multiValued":true }
  }' http://localhost:8983/api/cores/search_twitter/schema
```

Add a document with a multiValue field

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
          "twitter_id":5
          "links": "https://lucene.apache.org/solr",
          "links": "https://lucene.apache.org"
    }
    }
  }'
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=links:solr"  
```

Add dynamic field <dynamicField name="*_string" type="string" indexed="true" stored="true" />

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-dynamic-field":{
      "name":"*_string",
      "type":"string",
      "indexed":true,
      "stored":true
      }
  }' http://localhost:8983/api/cores/search_twitter/schema
```

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
        "twitter_id":6
          "user_name_string":"Bob",
          "type_string": "post",
          "lang_string": "eng"
    }
    }
  }'
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=lang_string:eng"
```

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-dynamic-field":{
      "name":"*_texts",
      "type":"text_general",
      "indexed":true,
      "stored":true,
      "multiValued":true 
      }
  }' http://localhost:8983/api/cores/search_twitter/schema
```

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
          "twitter_id":7
          "link_texts": "https://lucene.apache.org/solr",
          "link_texts": "https://lucene.apache.org"
    }
    }
  }'
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=link_texts:solr"
```

Add catch_all field <field name="catch_all" type="text_en" indexed="true" stored="false" multiValued="true"/>

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-field":{
      "name":"catch_all",
      "type":"text_en",
      "indexed":true,
      "stored":false,
      "multiValued":true }
  }' http://localhost:8983/api/cores/search_twitter/schema
```

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-copy-field":{
      "source":"user_name",
      "dest":[ "catch_all" ]}
  }' http://localhost:8983/api/cores/search_twitter/schema
```

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-copy-field":{
      "source":"content",
      "dest":[ "catch_all" ]}
  }' http://localhost:8983/api/cores/search_twitter/schema
```

```bash
  curl -X POST -H 'Content-type:application/json' --data-binary '{
    "add-copy-field":{
      "source":"links",
      "dest":[ "catch_all" ]}
  }' http://localhost:8983/api/cores/search_twitter/schema
```

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "add": {
      "doc": {
        "twitter_id":8
          "user_name":"apache",
          "content": "Happy searching!",
          "links": "https://lucene.apache.org/solr",
          "links": "https://lucene.apache.org"
    }
    }
  }'
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=apache&df=catch_all"
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=solr&df=catch_all"
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=happy&df=catch_all"
```


```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=*:*"
```

Delete documents by query

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "delete": {"query": "*:*"}
  }'
```

Add an array of documents

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "add": {
      "overwrite": false, 
      "commitWithin": 5000,
        "doc": {
            "twitter_id" : "9",
            "user_name_string" : "Solr",
            "type_string" : "post",
            "lang_string" : "en",
            "updated_on_pdt" : "2019-12-30T09:30:22Z",
            "likes_count_pint" : 10,
            "text_en" : "Happy Searching!",
            "link_strings" : ["https://github.com/apache/lucene-solr",
                        "https://lucene.apache.org/solr/"]
        }
    },
    "add": {
        "doc": {
            "twitter_id" : "10",
            "user_name_string" : "Solr",
            "type_string" : "post",
            "lang_string" : "en",
            "updated_on_pdt" : "2019-12-30T09:30:22Z",
            "likes_count_pint" : 10,
            "text_en" : "Happy Searching!",
            "link_strings" : ["https://github.com/apache/lucene-solr",
                        "https://lucene.apache.org/solr/"]
        }
    },
    "add": {
        "doc": {
            "twitter_id" : "11",
            "user_name_string" : "Solr",
            "type_string" : "post",
            "lang_string" : "en",
            "updated_on_pdt" : "2019-12-30T09:30:22Z",
            "likes_count_pint" : 10,
            "text_en" : "Happy Searching!",
            "link_strings" : ["https://github.com/apache/lucene-solr",
                        "https://lucene.apache.org/solr/"]
        }
    }
  }'
```

Delete document by id

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "delete": ["9","10"]
  }'
```

```bash
  curl -X GET "http://localhost:8983/solr/search_twitter/select?q=*:*"
```

Delete documents by query

```bash
  curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
  {
    "delete": {"query": "user_name_string:Solr"}
  }'
```

Add a document

```bash
curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
{
	 "add": {
	    "doc": {
	        "twitter_id" : "2",
	        "user_name_string" : "Solr",
	        "type_string" : "post",
	        "lang_string" : "en",
	        "updated_on_pdt" : "2019-12-30T09:30:22Z",
	        "likes_count_pint" : 10,
	        "text_en" : "Happy Searching!",
	        "subject_strings":"index",
	        "link_strings" : ["https://github.com/apache/lucene-solr",
	                    "https://lucene.apache.org/solr/"]
	    }
	}
}'
```

Update a document

```bash
curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
[{
    "twitter_id" : "2",	    
    "likes_count_pint" : {"set":11}	      
}]'
```

```bash
curl -X GET "http://localhost:8983/solr/search_twitter/select?q=*:*"
```

```bash
curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
[{
    "twitter_id" : "2",	  
    "likes_count_pint" : {"inc":1},  
    "subject_strings":{"add":["searching","database"]},
    "link_strings":{"remove":"https://github.com/apache/lucene-solr"}        
}]'
```

```bash
curl -X GET "http://localhost:8983/solr/search_twitter/select?q=*:*"
```

Get the version of a document using the get request handler

```bash
curl -X GET -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/get?id=2&fl=id,_version_'
```

```bash
curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?commitWithin=100' --data-binary '
[{
    "twitter_id" : "2",	    
    "likes_count_pint" : {"set":13}
}]'
```

Add 2 docs that will return the version

```bash
curl -X POST -H 'Content-Type: application/json' 'http://localhost:8983/solr/search_twitter/update?versions=true&omitHeader=true' --data-binary '
[ { "twitter_id" : "3" },
  { "twitter_id" : "4" } ]'
```