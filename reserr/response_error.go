package reserr

//OpenAPI middleware responder for errors
//Used: https://apigee.com/about/blog/technology/restful-api-design-what-about-errors as source

import (
	"github.com/go-openapi/runtime"
	"net/http"
)

type Error struct {
	Code int32 `json:"code"`
	Message string `json:"message"`
}


type UpdateUserByIDDefault struct {
	_statusCode int
	Payload *Error `json:"body,omitempty"`
}

// By default an unexpected error
func NewError(statusCode int) *UpdateUserByIDDefault {
	if statusCode <= 0 {
		statusCode = 500
	}

	return &UpdateUserByIDDefault{
		_statusCode: statusCode,
	}
}

//The API did something wrong
func NewUnexpectedError() *UpdateUserByIDDefault {
	return &UpdateUserByIDDefault{
		_statusCode: 500,
		Payload: &Error{
			Code: 500,
			Message: "Unexpected error",
		},
	}
}

//The application did something wrong
func NewAppError(message string) *UpdateUserByIDDefault {
	return &UpdateUserByIDDefault{
		_statusCode: 400,
		Payload: &Error{
			Code: 400,
			Message: message,
		},
	}
}

func NewPermissionsError(message string) *UpdateUserByIDDefault {
	return &UpdateUserByIDDefault{
		_statusCode: 401,
		Payload: &Error{
			Code: 401,
			Message: "You are unauthorized to this request",
		},
	}
}

// WithStatusCode adds the status to the update user by Id default response
func (o *UpdateUserByIDDefault) WithStatusCode(code int) *UpdateUserByIDDefault {
	o._statusCode = code
	return o
}

// SetStatusCode sets the status to the update user by Id default response
func (o *UpdateUserByIDDefault) SetStatusCode(code int) {
	o._statusCode = code
}

// WithPayload adds the payload to the update user by Id default response
func (o *UpdateUserByIDDefault) SetMessage(message string) *UpdateUserByIDDefault {
	if o.Payload == nil {
		o.Payload = &Error{}
	}
	o.Payload.Message = message
	return o
}

func (o *UpdateUserByIDDefault) SetCode(code int32) *UpdateUserByIDDefault {
	if o.Payload == nil {
		o.Payload = &Error{}
	}
	o.Payload.Code = code
	return o
}

// WriteResponse to the client
func (o *UpdateUserByIDDefault) WriteResponse(rw http.ResponseWriter, producer runtime.Producer) {
	rw.WriteHeader(o._statusCode)
	if o.Payload != nil {
		payload := o.Payload
		if err := producer.Produce(rw, payload); err != nil {
			panic(err) // let the recovery middleware deal with this
		}
	}
}