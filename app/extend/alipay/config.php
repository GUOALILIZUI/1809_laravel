<?php
$config = array (
    //应用ID,您的APPID。
    'app_id' => "2016092300576718",

    //商户私钥，您的原始格式RSA私钥
    'merchant_private_key' => "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCCwSUPRG5ntO3QVq8XPBW4qRtzyPVj96RLuuQY2caW7K9Tw8/gtERWaU5ANztA0KTFmHluGeGPzEarJJcD+equGeFE/eCPTDuSEjHtKWbE2LnsK7VGd7g31qk7+CTn7D3tY2qMAS54R0J5PXlfEap+yBIqikRj9FAJLsxqLso87DOhcFsE6oJlbewmODiyKi0bI13lOTxVG3WOS6ARFmLuN1nEQnFISFCtiN3DXbDfx/5v290e0F8ODUCmxoepmfTSHnJ3r1Y2RVzLgUzPKg7kNNwiTcqzhud5867i8roswLYhB7AtZQKjA4fawd2zKdLe/8PaUDIXz3SkDuuPl+AlAgMBAAECggEAKm8ubM8DmaqRR3zqY/r+/af8Hc6JPQFAk8c6gYojthVoLSIuU7mNOBIC8Do8g6Ny5iG+vumtV3KvOJmuXP79l7UUc8SE3VybNKOtCk/WZ2oCpM/mi9EMuypyT+EPcSktS95o1LkJcMWHoDtAKYddMroRkza+TUYbt281rfwzbCOsTL32IVMIkr75YTeiziAAGoSpTyW7scHq27gB0ba8Y1KS9OMxsXoO8Mi8qFIHctUyfUq950HDyA2TS8FRM04rjc/iqmDvsraFXrajWSL5urTl1mfmVEHfymVPo2dGstZ/HVzLfzQlcmLtlIsIkmUZxL9AMH4DArCajbsSxBklHQKBgQDzxFoS3RqHBQOXJEWz7u5XmZydJDvhFAN2mVwahQt/gZHnitB3/OGD+L4gzRAZF5i5DEDvWijY3LERUnbh4F6/ObWxi6UCP3fM7SZGC2iqmo2x67547UQXFW5QniLuJBOhndnaMqLlDfWkJYsHFqDbOAkzjF324A/XOzDRO8AQswKBgQCJUO7ppKB51SYYxpJ05tPQRqXL8BlnJvrJ2FCfwOAMyt3qyVNGNd8iLYgsDnOhYGZhoePnCjdVWgnaN3oQZWXU4khexl8cWTuxb1tTm2r8Gvf7aY+QN4UlPsxJIvFOCVwczp+nHDYgJs8uR3KlMoLgA8ZY2CUBo8RRcc2SLtIHxwKBgE4Xcg+m+2+TwKGzwgyxl3NCx7RjvjcN1UoyORpZ0uQnGxnFE6HMxmYj0qzpZKXVNFzbuxWymXFXyfXVqDYWTeQO1dEp/lOpB3UD6AX6c65r0sbT0fIleHG4sN1su530usFEs1y+agbdIPtT96Tur9tqqS/1YMjM4OY/lRUCgjYXAoGAfxdiWOtfAAQww4OecAZoiv+oWm36BQgF3CWS0ZlhhVWKOdFmerhHskl0HFqv2O/xMnH1DpTdC+lO7yKjnmNK8dMR6m4t/33zitEnNOXHClknphFYp8FLQWKzDwoBTxnIoHz5NWEeE3n4DbxhNtbeXNoBjZ9X+QGLJVpwStl82WcCgYAir64pPgyd3ZMImRkSMPS9PnBvOp+NUc6eLXmcbz1zK0i3pqUzKIqjjej3JusCKp9VZKpjxPtL2GIA9WeJugp4sc887+cTifv1GMsYwDgixE49HwBBXm9i10unjTiddIeFjrvTjq7Wt7dSNrp+LqRXIDWc59wNTiTagd2NJtC1kA==",

    //异步通知地址
    'notify_url' => "http://119.23.184.175/tell",

    //同步跳转
    'return_url' => "http:/119.23.184.175/result",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAswhS0eIK6Qv2CANrxYTfLJygOtq9qYlDlUuSnbzK4MREknROY92O7+DU5ZazR2dF+JO6OVt3vwdpGIo6J/aKvVWYBtALyO2jgI2I7lhXt44Wk01ym7GaOT7B7DANjMLgGNvc7PiXI4SO6aYhYeFuMPZlrmzF33BFLYbFRXMLwBhfZ1xEK7aWCqgp39EyZskteinMO0G8bYmQ7P7Gl2ZgKWeYSrkT94qpTXVjWkNh3cP5NFWVy2JDHYU2kjVqNrxWksFiQm+/Bc4/iMgme74eBKpSkTamo56Sjnqtm0ITeNtNqxPaqDpAS7iIfx487pEJ3/edk4IwK1/bmTI7xfUDVQIDAQAB"

);
return $config;
