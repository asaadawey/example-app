# PHP Filtering image API

## Api

The api is based on laravel framework and PHP 8.0.
Start by installing composer from here
https://getcomposer.org/

Start by installing the dependancies using the following command

```
composer install
```

Then fire up the server by running :

```
php artisan serve
```

## CLI

The cli works by requesting teh CSV file path from the user. The CLI will automatically export the content of the CSV files into the 'resources/json' and 'resources/xml'
Optional : The CLI will ask the user if he wants to export the output files in a custom directory.

to use the CLI , Run :

```
php artisan csv:convertor
```

after that
Add the full path of the csv file
And enter Y if you need to export it to the same path as your csv file

The CLI class is in 'api/app/Console/Commands/CSVConvertor.php'

## REST API

There is one POST request only that this api will serve
The POST is called /get_images

The POST controller also uses the Body request to apply the filtering options

E.g. How to use the filtering options

```
{
    "filter": {
        "name": {
            "end_with": "r"
        }
    }
}
```

```
{
    "filter": {
        "name": {
            "start_with": "ah"
        }
    }
}
```

```
{
    "filter": {
        "pvp": {
            "gte": 40
        }
    }
}
```

Available options for "name"

```
['end_with','start_with','contains','equals']
```

Available options for "pvp"

```
['gte' , 'lte' , 'equals']
```

Note : gte = Greater than or equals , Lte = Less than or equal

## Tests

The application have unit and feature tests inside the tests folder

## Steps

1- Start by generating the JSON and XML file by running the CLI Tool
2- Consume the REST API either via Postman or the frontend project

## What i am planning to do if i have enough time

1- Better error handling rather than using throw new error in the controller
2- Better CORS handling , I am using custom CORS middleware and i have rules to allow all
3- Add (AND , OR , NOT) operators for filering

# Client

The client is based on React,Typescript,Vite

## Why

Typescript for less error (i am familier with javascript but i prefer typescript)
Vite , for fast bundling and hot reload

Start by installing depandencies using `yarn` or `npm i`
Then serve the client by running `yarn dev` or `npm run dev`

## What i am planning to do if i have enough time

1- Better styling (by using sass , or MaterialUI for ready components)
2- Adding extra security layers
3- Better code splitting
