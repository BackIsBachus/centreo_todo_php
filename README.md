# Basic todo app based on Slim Framework 4 Skeleton Application

This is not meant to be anything production ready in any shape or form and only a basic increment for some technical test.

## Install the Application

To run the application in development, clone this repo and inside it you can run these commands 

```bash
composer install
composer start
```

After that, open `http://localhost:8080` in your browser.

## API structure

### Task JSON object

Instead of a single nested object and array of object can be inside of the "data" element.

```json
{
    "statusCode": 200,
    "data": {
        "uuid": "4befbd02-dfca-45ac-a5ce-02a13c3a3dd5",
        "title": "title",
        "comment": "comment",
        "createdAt": "2022-04-21T13:36:15+02:00",
        "lastUpdated": "2022-04-21T13:36:15+02:00",
        "done": false
    }
}
```


### /

GET - Returns the list of tasks that have not been done/finished.

### /task

GET - Returns the list of all tasks done or not.
POST - Create a new task to do with a title and comment
```json
{
    "title": "title",
    "comment": "comment"
}
```

### /task/<task_uuid>

GET - Returns the task matching the uuid provided
PUT - Updates the task matching the uuid provided (all fields are optional)
```json
{
    "title": "title",
    "comment": "comment",
    "done": true
}
```
DELETE - Deletes the task matching the uuid provided
