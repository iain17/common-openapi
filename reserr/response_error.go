package reserr

//OpenAPI middleware responder for errors
//Used: https://apigee.com/about/blog/technology/restful-api-design-what-about-errors as source

import (
	"github.com/go-openapi/runtime"
	"net/http"
)

type Error struct {
	Code int32 `json:"code"`
	Messages []string `json:"messages"`
}


type ErrorResponse struct {
	_statusCode int
	Payload *Error `json:"body,omitempty"`
}

// By default an unexpected error
func NewError(statusCode int) *ErrorResponse {
	if statusCode <= 0 {
		statusCode = 500
	}

	return &ErrorResponse{
		_statusCode: statusCode,
	}
}

//The API did something wrong
func NewUnexpectedError() *ErrorResponse {
	return &ErrorResponse{
		_statusCode: 500,
		Payload: &Error{
			Code: 500,
			Messages: []string{"Unexpected error"},
		},
	}
}

//The application did something wrong
func NewAppError(message string) *ErrorResponse {
	return &ErrorResponse{
		_statusCode: 400,
		Payload: &Error{
			Code: 400,
			Messages: []string{message},
		},
	}
}

func NewNonExistenceError(subject string) *ErrorResponse {
	return NewAppError(subject+" could not be found.").SetCode(404).SetStatusCode(404)
}

func NewPermissionsError() *ErrorResponse {
	return &ErrorResponse{
		_statusCode: 401,
		Payload: &Error{
			Code: 401,
			Messages: []string{"You are unauthorized to this request"},
		},
	}
}

func (o *ErrorResponse) SetStatusCode(code int) *ErrorResponse {
	o._statusCode = code
	return o
}

func (o *ErrorResponse) SetMessage(message string) *ErrorResponse {
	if o.Payload == nil {
		o.Payload = &Error{}
	}
	o.Payload.Messages = []string{message}
	return o
}

func (o *ErrorResponse) SetMessages(messages []string) *ErrorResponse {
	if o.Payload == nil {
		o.Payload = &Error{}
	}
	o.Payload.Messages = messages
	return o
}

func (o *ErrorResponse) AddMessage(message string) *ErrorResponse {
	if o.Payload == nil {
		o.Payload = &Error{
			Messages: []string{},
		}
	}
	o.Payload.Messages = append(o.Payload.Messages, message)
	return o
}

func (o *ErrorResponse) SetCode(code int32) *ErrorResponse {
	if o.Payload == nil {
		o.Payload = &Error{}
	}
	o.Payload.Code = code
	return o
}

// WriteResponse to the client
func (o *ErrorResponse) WriteResponse(rw http.ResponseWriter, producer runtime.Producer) {
	rw.WriteHeader(o._statusCode)
	if o.Payload != nil {
		payload := o.Payload
		if err := producer.Produce(rw, payload); err != nil {
			panic(err) // let the recovery middleware deal with this
		}
	}
}