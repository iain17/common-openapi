# OpenAPI: Response errors

This is a common responder you can use in your Go projects, to send error messages back in a consistent manner.
Make sure you use the [error definition in common.yml](../common.yml) in your responses and then reply like this:

## App error
```go
	res, err := operation()
	if err != nil {
		logger.Error(err)
		return reserr.NewUnexpectedError()
	}
```

Json:

```json
{
  "code": 500,
  "message": "Unexpected error"
}
```

## User error
```go
    if !userInput {
        logger.Warning(err)
        return reserr.NewAppError("You've made a wee mistake there :-).")
    }
```

Json:
```json
{
  "code": 400,
  "message": "You've made a wee mistake there :-)."
}
```

## App error with more details
If you'd like to give your user a little more to go on than just a "unexpected" error.

```go
ok := data.(string)//Example
if !ok {
    logger.Error(err)
    return reserr.NewUnexpectedError().SetCode(1000).SetMessage("Could not decode the data.")
}
```

This will return a error with http status code **500** and have a json response like this:

```json
{
  "code": 1000,
  "message": "Could not decode the data."
}
```

## Swagger definition file
Your swagger.yml file should look like this:
```yml
paths:
    /example:
        post:
          summary: Just to give you an idea.
          operationId: exampleOperations
          parameters:
            ...
          responses:
                  "200":
                    description: Yippie it worked!
                  default:
                    description: Operation could not completed.
                    schema:
                      $ref: "https://raw.githubusercontent.com/iain17/common-openapi/master/common.yml?#/Error"
```

## Sources
- [apigee: RESTful API Design: what about errors?](https://apigee.com/about/blog/technology/restful-api-design-what-about-errors as source)