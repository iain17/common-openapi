# OpenAPI: Response errors

This is a common responder you can use in your Go projects, to send error messages back in a consistent manner.
Make sure you use the [error defintion in common.yml](../common.yml) in your responses and then reply like this:

```go
	res, err := operation()
	if err != nil {
		logger.Error(err)
		return reserr.NewUnexpectedError()
	}
```

While your swagger.yml looks like this:
```yml


```

## Sources
- [apigee: RESTful API Design: what about errors?](https://apigee.com/about/blog/technology/restful-api-design-what-about-errors as source)