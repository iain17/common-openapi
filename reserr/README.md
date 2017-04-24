# OpenAPI: Response errors

This is a common responder you can use in your Go projects, to send error messages back in a consistent manner.
Make sure you use the [error defintion in common.yml](../common.yml) in your responses and then reply like this:

## App error:
```go
	res, err := operation()
	if err != nil {
		logger.Error(err)
		return reserr.NewUnexpectedError()
	}
```

## User error
```go
    if !userInput {
        logger.Warning(err)
        return reserr.NewAppError("You've made a wee mistake there :-).")
    }
```

##Swagger.yml
Your swagger definition file should look like this:
```yml
paths:
    /example:
        post:
          summary: Reset password of the user
          operationId: resetPassword
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