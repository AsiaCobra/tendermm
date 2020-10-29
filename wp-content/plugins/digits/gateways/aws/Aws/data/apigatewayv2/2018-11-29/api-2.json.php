<?php
// This file was auto-generated from sdk-root/src/data/apigatewayv2/2018-11-29/api-2.json
return [
	'metadata'    => [
		'apiVersion'       => '2018-11-29',
		'endpointPrefix'   => 'apigateway',
		'signingName'      => 'apigateway',
		'serviceFullName'  => 'AmazonApiGatewayV2',
		'serviceId'        => 'ApiGatewayV2',
		'protocol'         => 'rest-json',
		'jsonVersion'      => '1.1',
		'uid'              => 'apigatewayv2-2018-11-29',
		'signatureVersion' => 'v4',
	],
	'operations'  => [
		'CreateApi'                 => [
			'name'   => 'CreateApi',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/v2/apis', 'responseCode' => 201, ],
			'input'  => [ 'shape' => 'CreateApiRequest', ],
			'output' => [ 'shape' => 'CreateApiResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateApiMapping'          => [
			'name'   => 'CreateApiMapping',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/domainnames/{domainName}/apimappings',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateApiMappingRequest', ],
			'output' => [ 'shape' => 'CreateApiMappingResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateAuthorizer'          => [
			'name'   => 'CreateAuthorizer',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/authorizers',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateAuthorizerRequest', ],
			'output' => [ 'shape' => 'CreateAuthorizerResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateDeployment'          => [
			'name'   => 'CreateDeployment',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/deployments',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateDeploymentRequest', ],
			'output' => [ 'shape' => 'CreateDeploymentResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateDomainName'          => [
			'name'   => 'CreateDomainName',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/domainnames',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateDomainNameRequest', ],
			'output' => [ 'shape' => 'CreateDomainNameResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateIntegration'         => [
			'name'   => 'CreateIntegration',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/integrations',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateIntegrationRequest', ],
			'output' => [ 'shape' => 'CreateIntegrationResult', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateIntegrationResponse' => [
			'name'   => 'CreateIntegrationResponse',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}/integrationresponses',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateIntegrationResponseRequest', ],
			'output' => [ 'shape' => 'CreateIntegrationResponseResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateModel'               => [
			'name'   => 'CreateModel',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/models',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateModelRequest', ],
			'output' => [ 'shape' => 'CreateModelResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateRoute'               => [
			'name'   => 'CreateRoute',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/routes',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateRouteRequest', ],
			'output' => [ 'shape' => 'CreateRouteResult', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateRouteResponse'       => [
			'name'   => 'CreateRouteResponse',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}/routeresponses',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateRouteResponseRequest', ],
			'output' => [ 'shape' => 'CreateRouteResponseResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'CreateStage'               => [
			'name'   => 'CreateStage',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/apis/{apiId}/stages',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateStageRequest', ],
			'output' => [ 'shape' => 'CreateStageResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'DeleteApi'                 => [
			'name'   => 'DeleteApi',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteApiRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteApiMapping'          => [
			'name'   => 'DeleteApiMapping',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/domainnames/{domainName}/apimappings/{apiMappingId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteApiMappingRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'DeleteAuthorizer'          => [
			'name'   => 'DeleteAuthorizer',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/authorizers/{authorizerId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteAuthorizerRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteDeployment'          => [
			'name'   => 'DeleteDeployment',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/deployments/{deploymentId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteDeploymentRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteDomainName'          => [
			'name'   => 'DeleteDomainName',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/domainnames/{domainName}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteDomainNameRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteIntegration'         => [
			'name'   => 'DeleteIntegration',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteIntegrationRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteIntegrationResponse' => [
			'name'   => 'DeleteIntegrationResponse',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}/integrationresponses/{integrationResponseId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteIntegrationResponseRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteModel'               => [
			'name'   => 'DeleteModel',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/models/{modelId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteModelRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteRoute'               => [
			'name'   => 'DeleteRoute',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteRouteRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteRouteResponse'       => [
			'name'   => 'DeleteRouteResponse',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}/routeresponses/{routeResponseId}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteRouteResponseRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'DeleteStage'               => [
			'name'   => 'DeleteStage',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/apis/{apiId}/stages/{stageName}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteStageRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetApi'                    => [
			'name'   => 'GetApi',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetApiRequest', ],
			'output' => [ 'shape' => 'GetApiResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetApiMapping'             => [
			'name'   => 'GetApiMapping',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/domainnames/{domainName}/apimappings/{apiMappingId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetApiMappingRequest', ],
			'output' => [ 'shape' => 'GetApiMappingResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetApiMappings'            => [
			'name'   => 'GetApiMappings',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/domainnames/{domainName}/apimappings',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetApiMappingsRequest', ],
			'output' => [ 'shape' => 'GetApiMappingsResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetApis'                   => [
			'name'   => 'GetApis',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetApisRequest', ],
			'output' => [ 'shape' => 'GetApisResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetAuthorizer'             => [
			'name'   => 'GetAuthorizer',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/authorizers/{authorizerId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetAuthorizerRequest', ],
			'output' => [ 'shape' => 'GetAuthorizerResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetAuthorizers'            => [
			'name'   => 'GetAuthorizers',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/authorizers',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetAuthorizersRequest', ],
			'output' => [ 'shape' => 'GetAuthorizersResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetDeployment'             => [
			'name'   => 'GetDeployment',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/deployments/{deploymentId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetDeploymentRequest', ],
			'output' => [ 'shape' => 'GetDeploymentResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetDeployments'            => [
			'name'   => 'GetDeployments',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/deployments',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetDeploymentsRequest', ],
			'output' => [ 'shape' => 'GetDeploymentsResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetDomainName'             => [
			'name'   => 'GetDomainName',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/domainnames/{domainName}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetDomainNameRequest', ],
			'output' => [ 'shape' => 'GetDomainNameResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetDomainNames'            => [
			'name'   => 'GetDomainNames',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/domainnames',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetDomainNamesRequest', ],
			'output' => [ 'shape' => 'GetDomainNamesResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetIntegration'            => [
			'name'   => 'GetIntegration',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetIntegrationRequest', ],
			'output' => [ 'shape' => 'GetIntegrationResult', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetIntegrationResponse'    => [
			'name'   => 'GetIntegrationResponse',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}/integrationresponses/{integrationResponseId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetIntegrationResponseRequest', ],
			'output' => [ 'shape' => 'GetIntegrationResponseResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetIntegrationResponses'   => [
			'name'   => 'GetIntegrationResponses',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}/integrationresponses',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetIntegrationResponsesRequest', ],
			'output' => [ 'shape' => 'GetIntegrationResponsesResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetIntegrations'           => [
			'name'   => 'GetIntegrations',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/integrations',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetIntegrationsRequest', ],
			'output' => [ 'shape' => 'GetIntegrationsResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetModel'                  => [
			'name'   => 'GetModel',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/models/{modelId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetModelRequest', ],
			'output' => [ 'shape' => 'GetModelResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetModelTemplate'          => [
			'name'   => 'GetModelTemplate',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/models/{modelId}/template',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetModelTemplateRequest', ],
			'output' => [ 'shape' => 'GetModelTemplateResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetModels'                 => [
			'name'   => 'GetModels',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/models',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetModelsRequest', ],
			'output' => [ 'shape' => 'GetModelsResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetRoute'                  => [
			'name'   => 'GetRoute',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetRouteRequest', ],
			'output' => [ 'shape' => 'GetRouteResult', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetRouteResponse'          => [
			'name'   => 'GetRouteResponse',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}/routeresponses/{routeResponseId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetRouteResponseRequest', ],
			'output' => [ 'shape' => 'GetRouteResponseResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetRouteResponses'         => [
			'name'   => 'GetRouteResponses',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}/routeresponses',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetRouteResponsesRequest', ],
			'output' => [ 'shape' => 'GetRouteResponsesResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetRoutes'                 => [
			'name'   => 'GetRoutes',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/routes',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetRoutesRequest', ],
			'output' => [ 'shape' => 'GetRoutesResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetStage'                  => [
			'name'   => 'GetStage',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/stages/{stageName}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetStageRequest', ],
			'output' => [ 'shape' => 'GetStageResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
			],
		],
		'GetStages'                 => [
			'name'   => 'GetStages',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/apis/{apiId}/stages',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetStagesRequest', ],
			'output' => [ 'shape' => 'GetStagesResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
			],
		],
		'GetTags'                   => [
			'name'   => 'GetTags',
			'http'   => [
				'method'       => 'GET',
				'requestUri'   => '/v2/tags/{resource-arn}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'GetTagsRequest', ],
			'output' => [ 'shape' => 'GetTagsResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'TagResource'               => [
			'name'   => 'TagResource',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/v2/tags/{resource-arn}',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'TagResourceRequest', ],
			'output' => [ 'shape' => 'TagResourceResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UntagResource'             => [
			'name'   => 'UntagResource',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/v2/tags/{resource-arn}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'UntagResourceRequest', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateApi'                 => [
			'name'   => 'UpdateApi',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateApiRequest', ],
			'output' => [ 'shape' => 'UpdateApiResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateApiMapping'          => [
			'name'   => 'UpdateApiMapping',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/domainnames/{domainName}/apimappings/{apiMappingId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateApiMappingRequest', ],
			'output' => [ 'shape' => 'UpdateApiMappingResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateAuthorizer'          => [
			'name'   => 'UpdateAuthorizer',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/authorizers/{authorizerId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateAuthorizerRequest', ],
			'output' => [ 'shape' => 'UpdateAuthorizerResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateDeployment'          => [
			'name'   => 'UpdateDeployment',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/deployments/{deploymentId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateDeploymentRequest', ],
			'output' => [ 'shape' => 'UpdateDeploymentResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateDomainName'          => [
			'name'   => 'UpdateDomainName',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/domainnames/{domainName}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateDomainNameRequest', ],
			'output' => [ 'shape' => 'UpdateDomainNameResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateIntegration'         => [
			'name'   => 'UpdateIntegration',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateIntegrationRequest', ],
			'output' => [ 'shape' => 'UpdateIntegrationResult', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateIntegrationResponse' => [
			'name'   => 'UpdateIntegrationResponse',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/integrations/{integrationId}/integrationresponses/{integrationResponseId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateIntegrationResponseRequest', ],
			'output' => [ 'shape' => 'UpdateIntegrationResponseResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateModel'               => [
			'name'   => 'UpdateModel',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/models/{modelId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateModelRequest', ],
			'output' => [ 'shape' => 'UpdateModelResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateRoute'               => [
			'name'   => 'UpdateRoute',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateRouteRequest', ],
			'output' => [ 'shape' => 'UpdateRouteResult', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateRouteResponse'       => [
			'name'   => 'UpdateRouteResponse',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/routes/{routeId}/routeresponses/{routeResponseId}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateRouteResponseRequest', ],
			'output' => [ 'shape' => 'UpdateRouteResponseResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
		'UpdateStage'               => [
			'name'   => 'UpdateStage',
			'http'   => [
				'method'       => 'PATCH',
				'requestUri'   => '/v2/apis/{apiId}/stages/{stageName}',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'UpdateStageRequest', ],
			'output' => [ 'shape' => 'UpdateStageResponse', ],
			'errors' => [
				[ 'shape' => 'NotFoundException', ],
				[ 'shape' => 'TooManyRequestsException', ],
				[ 'shape' => 'BadRequestException', ],
				[ 'shape' => 'ConflictException', ],
			],
		],
	],
	'shapes'      => [
		'AccessLogSettings'                  => [
			'type'    => 'structure',
			'members' => [
				'DestinationArn' => [
					'shape'        => 'Arn',
					'locationName' => 'destinationArn',
				],
				'Format'         => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'format',
				],
			],
		],
		'Api'                                => [
			'type'     => 'structure',
			'members'  => [
				'ApiEndpoint'               => [ 'shape' => '__string', 'locationName' => 'apiEndpoint', ],
				'ApiId'                     => [ 'shape' => 'Id', 'locationName' => 'apiId', ],
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'CreatedDate'               => [ 'shape' => '__timestampIso8601', 'locationName' => 'createdDate', ],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [ 'shape' => '__boolean', 'locationName' => 'disableSchemaValidation', ],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProtocolType'              => [ 'shape' => 'ProtocolType', 'locationName' => 'protocolType', ],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
				'Warnings'                  => [ 'shape' => '__listOf__string', 'locationName' => 'warnings', ],
				'Tags'                      => [ 'shape' => 'Tags', 'locationName' => 'tags', ],
			],
			'required' => [ 'RouteSelectionExpression', 'ProtocolType', 'Name', ],
		],
		'ApiMapping'                         => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'         => [ 'shape' => 'Id', 'locationName' => 'apiId', ],
				'ApiMappingId'  => [
					'shape'        => 'Id',
					'locationName' => 'apiMappingId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
			'required' => [ 'Stage', 'ApiId', ],
		],
		'ApiMappings'                        => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfApiMapping',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'Apis'                               => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [ 'shape' => '__listOfApi', 'locationName' => 'items', ],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'Arn'                                => [ 'type' => 'string', ],
		'AuthorizationScopes'                => [
			'type'   => 'list',
			'member' => [ 'shape' => 'StringWithLengthBetween1And64', ],
		],
		'AuthorizationType'                  => [ 'type' => 'string', 'enum' => [ 'NONE', 'AWS_IAM', 'CUSTOM', ], ],
		'Authorizer'                         => [
			'type'     => 'structure',
			'members'  => [
				'AuthorizerCredentialsArn'     => [
					'shape'        => 'Arn',
					'locationName' => 'authorizerCredentialsArn',
				],
				'AuthorizerId'                 => [
					'shape'        => 'Id',
					'locationName' => 'authorizerId',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [
					'shape'        => 'AuthorizerType',
					'locationName' => 'authorizerType',
				],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [
					'shape'        => 'ProviderArnList',
					'locationName' => 'providerArns',
				],
			],
			'required' => [ 'Name', ],
		],
		'AuthorizerType'                     => [ 'type' => 'string', 'enum' => [ 'REQUEST', ], ],
		'Authorizers'                        => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfAuthorizer',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'BadRequestException'                => [
			'type'      => 'structure',
			'members'   => [
				'Message' => [
					'shape'        => '__string',
					'locationName' => 'message',
				],
			],
			'exception' => true,
			'error'     => [ 'httpStatusCode' => 400, ],
		],
		'ConflictException'                  => [
			'type'      => 'structure',
			'members'   => [
				'Message' => [
					'shape'        => '__string',
					'locationName' => 'message',
				],
			],
			'exception' => true,
			'error'     => [ 'httpStatusCode' => 409, ],
		],
		'ConnectionType'                     => [ 'type' => 'string', 'enum' => [ 'INTERNET', 'VPC_LINK', ], ],
		'ContentHandlingStrategy'            => [
			'type' => 'string',
			'enum' => [ 'CONVERT_TO_BINARY', 'CONVERT_TO_TEXT', ],
		],
		'CreateApiInput'                     => [
			'type'     => 'structure',
			'members'  => [
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [
					'shape'        => '__boolean',
					'locationName' => 'disableSchemaValidation',
				],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProtocolType'              => [
					'shape'        => 'ProtocolType',
					'locationName' => 'protocolType',
				],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
				'Tags'                      => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
			'required' => [ 'RouteSelectionExpression', 'ProtocolType', 'Name', ],
		],
		'CreateApiMappingInput'              => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'         => [
					'shape'        => 'Id',
					'locationName' => 'apiId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
			'required' => [ 'Stage', 'ApiId', ],
		],
		'CreateApiMappingRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'         => [
					'shape'        => 'Id',
					'locationName' => 'apiId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'DomainName'    => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
			'required' => [ 'DomainName', 'Stage', 'ApiId', ],
		],
		'CreateApiMappingResponse'           => [
			'type'    => 'structure',
			'members' => [
				'ApiId'         => [
					'shape'        => 'Id',
					'locationName' => 'apiId',
				],
				'ApiMappingId'  => [
					'shape'        => 'Id',
					'locationName' => 'apiMappingId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
		],
		'CreateApiRequest'                   => [
			'type'     => 'structure',
			'members'  => [
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [
					'shape'        => '__boolean',
					'locationName' => 'disableSchemaValidation',
				],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProtocolType'              => [
					'shape'        => 'ProtocolType',
					'locationName' => 'protocolType',
				],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
			],
			'required' => [ 'RouteSelectionExpression', 'ProtocolType', 'Name', ],
		],
		'CreateApiResponse'                  => [
			'type'    => 'structure',
			'members' => [
				'ApiEndpoint'               => [ 'shape' => '__string', 'locationName' => 'apiEndpoint', ],
				'ApiId'                     => [ 'shape' => 'Id', 'locationName' => 'apiId', ],
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'CreatedDate'               => [ 'shape' => '__timestampIso8601', 'locationName' => 'createdDate', ],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [ 'shape' => '__boolean', 'locationName' => 'disableSchemaValidation', ],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProtocolType'              => [ 'shape' => 'ProtocolType', 'locationName' => 'protocolType', ],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
				'Warnings'                  => [ 'shape' => '__listOf__string', 'locationName' => 'warnings', ],
			],
		],
		'CreateAuthorizerInput'              => [
			'type'     => 'structure',
			'members'  => [
				'AuthorizerCredentialsArn'     => [
					'shape'        => 'Arn',
					'locationName' => 'authorizerCredentialsArn',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [
					'shape'        => 'AuthorizerType',
					'locationName' => 'authorizerType',
				],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [
					'shape'        => 'ProviderArnList',
					'locationName' => 'providerArns',
				],
			],
			'required' => [ 'AuthorizerUri', 'AuthorizerType', 'IdentitySource', 'Name', ],
		],
		'CreateAuthorizerRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                        => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'AuthorizerCredentialsArn'     => [
					'shape'        => 'Arn',
					'locationName' => 'authorizerCredentialsArn',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [
					'shape'        => 'AuthorizerType',
					'locationName' => 'authorizerType',
				],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [
					'shape'        => 'ProviderArnList',
					'locationName' => 'providerArns',
				],
			],
			'required' => [ 'ApiId', 'AuthorizerUri', 'AuthorizerType', 'IdentitySource', 'Name', ],
		],
		'CreateAuthorizerResponse'           => [
			'type'    => 'structure',
			'members' => [
				'AuthorizerCredentialsArn'     => [
					'shape'        => 'Arn',
					'locationName' => 'authorizerCredentialsArn',
				],
				'AuthorizerId'                 => [
					'shape'        => 'Id',
					'locationName' => 'authorizerId',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [
					'shape'        => 'AuthorizerType',
					'locationName' => 'authorizerType',
				],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [
					'shape'        => 'ProviderArnList',
					'locationName' => 'providerArns',
				],
			],
		],
		'CreateDeploymentInput'              => [
			'type'    => 'structure',
			'members' => [
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'StageName'   => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
			],
		],
		'CreateDeploymentRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'StageName'   => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'CreateDeploymentResponse'           => [
			'type'    => 'structure',
			'members' => [
				'CreatedDate'             => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DeploymentId'            => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'DeploymentStatus'        => [
					'shape'        => 'DeploymentStatus',
					'locationName' => 'deploymentStatus',
				],
				'DeploymentStatusMessage' => [
					'shape'        => '__string',
					'locationName' => 'deploymentStatusMessage',
				],
				'Description'             => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
			],
		],
		'CreateDomainNameInput'              => [
			'type'     => 'structure',
			'members'  => [
				'DomainName'               => [
					'shape'        => 'StringWithLengthBetween1And512',
					'locationName' => 'domainName',
				],
				'DomainNameConfigurations' => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
				'Tags'                     => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
			'required' => [ 'DomainName', ],
		],
		'CreateDomainNameRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'DomainName'               => [
					'shape'        => 'StringWithLengthBetween1And512',
					'locationName' => 'domainName',
				],
				'DomainNameConfigurations' => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
				'Tags'                     => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
			'required' => [ 'DomainName', ],
		],
		'CreateDomainNameResponse'           => [
			'type'    => 'structure',
			'members' => [
				'ApiMappingSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiMappingSelectionExpression',
				],
				'DomainName'                    => [
					'shape'        => 'StringWithLengthBetween1And512',
					'locationName' => 'domainName',
				],
				'DomainNameConfigurations'      => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
				'Tags'                          => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
		],
		'CreateIntegrationInput'             => [
			'type'     => 'structure',
			'members'  => [
				'ConnectionId'                => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'              => [ 'shape' => 'ConnectionType', 'locationName' => 'connectionType', ],
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'              => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                 => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationMethod'           => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationType'             => [ 'shape' => 'IntegrationType', 'locationName' => 'integrationType', ],
				'IntegrationUri'              => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'         => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'           => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'            => [ 'shape' => 'TemplateMap', 'locationName' => 'requestTemplates', ],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'             => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
			'required' => [ 'IntegrationType', ],
		],
		'CreateIntegrationRequest'           => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ConnectionId'                => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'              => [ 'shape' => 'ConnectionType', 'locationName' => 'connectionType', ],
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'              => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                 => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationMethod'           => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationType'             => [ 'shape' => 'IntegrationType', 'locationName' => 'integrationType', ],
				'IntegrationUri'              => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'         => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'           => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'            => [ 'shape' => 'TemplateMap', 'locationName' => 'requestTemplates', ],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'             => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
			'required' => [ 'ApiId', 'IntegrationType', ],
		],
		'CreateIntegrationResult'            => [
			'type'    => 'structure',
			'members' => [
				'ConnectionId'                           => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'                         => [
					'shape'        => 'ConnectionType',
					'locationName' => 'connectionType',
				],
				'ContentHandlingStrategy'                => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'                         => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                            => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationId'                          => [ 'shape' => 'Id', 'locationName' => 'integrationId', ],
				'IntegrationMethod'                      => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'integrationResponseSelectionExpression',
				],
				'IntegrationType'                        => [
					'shape'        => 'IntegrationType',
					'locationName' => 'integrationType',
				],
				'IntegrationUri'                         => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'                    => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'                      => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'                       => [
					'shape'        => 'TemplateMap',
					'locationName' => 'requestTemplates',
				],
				'TemplateSelectionExpression'            => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'                        => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
		],
		'CreateIntegrationResponseInput'     => [
			'type'     => 'structure',
			'members'  => [
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
			'required' => [ 'IntegrationResponseKey', ],
		],
		'CreateIntegrationResponseRequest'   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationId'               => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
			'required' => [ 'ApiId', 'IntegrationId', 'IntegrationResponseKey', ],
		],
		'CreateIntegrationResponseResponse'  => [
			'type'    => 'structure',
			'members' => [
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationResponseId'       => [
					'shape'        => 'Id',
					'locationName' => 'integrationResponseId',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
		],
		'CreateModelInput'                   => [
			'type'     => 'structure',
			'members'  => [
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
			'required' => [ 'Schema', 'Name', ],
		],
		'CreateModelRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
			'required' => [ 'ApiId', 'Schema', 'Name', ],
		],
		'CreateModelResponse'                => [
			'type'    => 'structure',
			'members' => [
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'ModelId'     => [
					'shape'        => 'Id',
					'locationName' => 'modelId',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
		],
		'CreateRouteInput'                   => [
			'type'     => 'structure',
			'members'  => [
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
			'required' => [ 'RouteKey', ],
		],
		'CreateRouteRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                            => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
			'required' => [ 'ApiId', 'RouteKey', ],
		],
		'CreateRouteResult'                  => [
			'type'    => 'structure',
			'members' => [
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteId'                          => [ 'shape' => 'Id', 'locationName' => 'routeId', ],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
		],
		'CreateRouteResponseInput'           => [
			'type'     => 'structure',
			'members'  => [
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
			'required' => [ 'RouteResponseKey', ],
		],
		'CreateRouteResponseRequest'         => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                    => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteId'                  => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
			'required' => [ 'ApiId', 'RouteId', 'RouteResponseKey', ],
		],
		'CreateRouteResponseResponse'        => [
			'type'    => 'structure',
			'members' => [
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteResponseId'          => [
					'shape'        => 'Id',
					'locationName' => 'routeResponseId',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
		],
		'CreateStageInput'                   => [
			'type'     => 'structure',
			'members'  => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ClientCertificateId'  => [
					'shape'        => 'Id',
					'locationName' => 'clientCertificateId',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageName'            => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
				'Tags'                 => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
			'required' => [ 'StageName', ],
		],
		'CreateStageRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ApiId'                => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ClientCertificateId'  => [
					'shape'        => 'Id',
					'locationName' => 'clientCertificateId',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageName'            => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
				'Tags'                 => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
			'required' => [ 'ApiId', 'StageName', ],
		],
		'CreateStageResponse'                => [
			'type'    => 'structure',
			'members' => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ClientCertificateId'  => [ 'shape' => 'Id', 'locationName' => 'clientCertificateId', ],
				'CreatedDate'          => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [ 'shape' => 'Id', 'locationName' => 'deploymentId', ],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'LastUpdatedDate'      => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'lastUpdatedDate',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageName'            => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
				'Tags'                 => [ 'shape' => 'Tags', 'locationName' => 'tags', ],
			],
		],
		'DeleteApiMappingRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiMappingId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiMappingId',
				],
				'DomainName'   => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
			],
			'required' => [ 'ApiMappingId', 'DomainName', ],
		],
		'DeleteApiRequest'                   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'DeleteAuthorizerRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'        => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'AuthorizerId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'authorizerId',
				],
			],
			'required' => [ 'AuthorizerId', 'ApiId', ],
		],
		'DeleteDeploymentRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'        => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'DeploymentId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'deploymentId',
				],
			],
			'required' => [ 'ApiId', 'DeploymentId', ],
		],
		'DeleteDomainNameRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'DomainName' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
			],
			'required' => [ 'DomainName', ],
		],
		'DeleteIntegrationRequest'           => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'         => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'IntegrationId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
			],
			'required' => [ 'ApiId', 'IntegrationId', ],
		],
		'DeleteIntegrationResponseRequest'   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                 => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'IntegrationId'         => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
				'IntegrationResponseId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationResponseId',
				],
			],
			'required' => [ 'ApiId', 'IntegrationResponseId', 'IntegrationId', ],
		],
		'DeleteModelRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'   => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ModelId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'modelId',
				],
			],
			'required' => [ 'ModelId', 'ApiId', ],
		],
		'DeleteRouteRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'   => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'RouteId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
			],
			'required' => [ 'ApiId', 'RouteId', ],
		],
		'DeleteRouteResponseRequest'         => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'           => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'RouteId'         => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
				'RouteResponseId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeResponseId',
				],
			],
			'required' => [ 'RouteResponseId', 'ApiId', 'RouteId', ],
		],
		'DeleteStageRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'     => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'StageName' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'stageName',
				],
			],
			'required' => [ 'StageName', 'ApiId', ],
		],
		'Deployment'                         => [
			'type'    => 'structure',
			'members' => [
				'CreatedDate'             => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DeploymentId'            => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'DeploymentStatus'        => [
					'shape'        => 'DeploymentStatus',
					'locationName' => 'deploymentStatus',
				],
				'DeploymentStatusMessage' => [
					'shape'        => '__string',
					'locationName' => 'deploymentStatusMessage',
				],
				'Description'             => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
			],
		],
		'DeploymentStatus'                   => [ 'type' => 'string', 'enum' => [ 'PENDING', 'FAILED', 'DEPLOYED', ], ],
		'Deployments'                        => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfDeployment',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'DomainName'                         => [
			'type'     => 'structure',
			'members'  => [
				'ApiMappingSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiMappingSelectionExpression',
				],
				'DomainName'                    => [
					'shape'        => 'StringWithLengthBetween1And512',
					'locationName' => 'domainName',
				],
				'DomainNameConfigurations'      => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
				'Tags'                          => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
			'required' => [ 'DomainName', ],
		],
		'DomainNameConfiguration'            => [
			'type'    => 'structure',
			'members' => [
				'ApiGatewayDomainName'    => [
					'shape'        => '__string',
					'locationName' => 'apiGatewayDomainName',
				],
				'CertificateArn'          => [
					'shape'        => 'Arn',
					'locationName' => 'certificateArn',
				],
				'CertificateName'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'certificateName',
				],
				'CertificateUploadDate'   => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'certificateUploadDate',
				],
				'EndpointType'            => [
					'shape'        => 'EndpointType',
					'locationName' => 'endpointType',
				],
				'HostedZoneId'            => [
					'shape'        => '__string',
					'locationName' => 'hostedZoneId',
				],
				'SecurityPolicy'          => [
					'shape'        => 'SecurityPolicy',
					'locationName' => 'securityPolicy',
				],
				'DomainNameStatus'        => [
					'shape'        => 'DomainNameStatus',
					'locationName' => 'domainNameStatus',
				],
				'DomainNameStatusMessage' => [
					'shape'        => '__string',
					'locationName' => 'domainNameStatusMessage',
				],
			],
		],
		'DomainNameConfigurations'           => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DomainNameConfiguration', ],
		],
		'DomainNames'                        => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfDomainName',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'EndpointType'                       => [ 'type' => 'string', 'enum' => [ 'REGIONAL', 'EDGE', ], ],
		'SecurityPolicy'                     => [ 'type' => 'string', 'enum' => [ 'TLS_1_0', 'TLS_1_2', ], ],
		'DomainNameStatus'                   => [ 'type' => 'string', 'enum' => [ 'AVAILABLE', 'UPDATING', ], ],
		'GetApiMappingRequest'               => [
			'type'     => 'structure',
			'members'  => [
				'ApiMappingId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiMappingId',
				],
				'DomainName'   => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
			],
			'required' => [ 'ApiMappingId', 'DomainName', ],
		],
		'GetApiMappingResponse'              => [
			'type'    => 'structure',
			'members' => [
				'ApiId'         => [
					'shape'        => 'Id',
					'locationName' => 'apiId',
				],
				'ApiMappingId'  => [
					'shape'        => 'Id',
					'locationName' => 'apiMappingId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
		],
		'GetApiMappingsRequest'              => [
			'type'     => 'structure',
			'members'  => [
				'DomainName' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'DomainName', ],
		],
		'GetApiMappingsResponse'             => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfApiMapping',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetApiRequest'                      => [
			'type'     => 'structure',
			'members'  => [
				'ApiId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'GetApiResponse'                     => [
			'type'    => 'structure',
			'members' => [
				'ApiEndpoint'               => [ 'shape' => '__string', 'locationName' => 'apiEndpoint', ],
				'ApiId'                     => [ 'shape' => 'Id', 'locationName' => 'apiId', ],
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'CreatedDate'               => [ 'shape' => '__timestampIso8601', 'locationName' => 'createdDate', ],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [ 'shape' => '__boolean', 'locationName' => 'disableSchemaValidation', ],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProtocolType'              => [ 'shape' => 'ProtocolType', 'locationName' => 'protocolType', ],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
				'Warnings'                  => [ 'shape' => '__listOf__string', 'locationName' => 'warnings', ],
				'Tags'                      => [ 'shape' => 'Tags', 'locationName' => 'tags', ],
			],
		],
		'GetApisRequest'                     => [
			'type'    => 'structure',
			'members' => [
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetApisResponse'                    => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfApi',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetAuthorizerRequest'               => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'        => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'AuthorizerId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'authorizerId',
				],
			],
			'required' => [ 'AuthorizerId', 'ApiId', ],
		],
		'GetAuthorizerResponse'              => [
			'type'    => 'structure',
			'members' => [
				'AuthorizerCredentialsArn'     => [
					'shape'        => 'Arn',
					'locationName' => 'authorizerCredentialsArn',
				],
				'AuthorizerId'                 => [
					'shape'        => 'Id',
					'locationName' => 'authorizerId',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [
					'shape'        => 'AuthorizerType',
					'locationName' => 'authorizerType',
				],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [
					'shape'        => 'ProviderArnList',
					'locationName' => 'providerArns',
				],
			],
		],
		'GetAuthorizersRequest'              => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'      => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'GetAuthorizersResponse'             => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfAuthorizer',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetDeploymentRequest'               => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'        => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'DeploymentId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'deploymentId',
				],
			],
			'required' => [ 'ApiId', 'DeploymentId', ],
		],
		'GetDeploymentResponse'              => [
			'type'    => 'structure',
			'members' => [
				'CreatedDate'             => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DeploymentId'            => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'DeploymentStatus'        => [
					'shape'        => 'DeploymentStatus',
					'locationName' => 'deploymentStatus',
				],
				'DeploymentStatusMessage' => [
					'shape'        => '__string',
					'locationName' => 'deploymentStatusMessage',
				],
				'Description'             => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
			],
		],
		'GetDeploymentsRequest'              => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'      => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'GetDeploymentsResponse'             => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfDeployment',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetDomainNameRequest'               => [
			'type'     => 'structure',
			'members'  => [
				'DomainName' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
			],
			'required' => [ 'DomainName', ],
		],
		'GetDomainNameResponse'              => [
			'type'    => 'structure',
			'members' => [
				'ApiMappingSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiMappingSelectionExpression',
				],
				'DomainName'                    => [
					'shape'        => 'StringWithLengthBetween1And512',
					'locationName' => 'domainName',
				],
				'DomainNameConfigurations'      => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
				'Tags'                          => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
		],
		'GetDomainNamesRequest'              => [
			'type'    => 'structure',
			'members' => [
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetDomainNamesResponse'             => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfDomainName',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetIntegrationRequest'              => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'         => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'IntegrationId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
			],
			'required' => [ 'ApiId', 'IntegrationId', ],
		],
		'GetIntegrationResult'               => [
			'type'    => 'structure',
			'members' => [
				'ConnectionId'                           => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'                         => [
					'shape'        => 'ConnectionType',
					'locationName' => 'connectionType',
				],
				'ContentHandlingStrategy'                => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'                         => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                            => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationId'                          => [ 'shape' => 'Id', 'locationName' => 'integrationId', ],
				'IntegrationMethod'                      => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'integrationResponseSelectionExpression',
				],
				'IntegrationType'                        => [
					'shape'        => 'IntegrationType',
					'locationName' => 'integrationType',
				],
				'IntegrationUri'                         => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'                    => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'                      => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'                       => [
					'shape'        => 'TemplateMap',
					'locationName' => 'requestTemplates',
				],
				'TemplateSelectionExpression'            => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'                        => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
		],
		'GetIntegrationResponseRequest'      => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                 => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'IntegrationId'         => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
				'IntegrationResponseId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationResponseId',
				],
			],
			'required' => [ 'ApiId', 'IntegrationResponseId', 'IntegrationId', ],
		],
		'GetIntegrationResponseResponse'     => [
			'type'    => 'structure',
			'members' => [
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationResponseId'       => [
					'shape'        => 'Id',
					'locationName' => 'integrationResponseId',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
		],
		'GetIntegrationResponsesRequest'     => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'         => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'IntegrationId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
				'MaxResults'    => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'     => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'IntegrationId', 'ApiId', ],
		],
		'GetIntegrationResponsesResponse'    => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfIntegrationResponse',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetIntegrationsRequest'             => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'      => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'GetIntegrationsResponse'            => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfIntegration',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetModelRequest'                    => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'   => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ModelId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'modelId',
				],
			],
			'required' => [ 'ModelId', 'ApiId', ],
		],
		'GetModelResponse'                   => [
			'type'    => 'structure',
			'members' => [
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'ModelId'     => [
					'shape'        => 'Id',
					'locationName' => 'modelId',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
		],
		'GetModelTemplateRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'   => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ModelId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'modelId',
				],
			],
			'required' => [ 'ModelId', 'ApiId', ],
		],
		'GetModelTemplateResponse'           => [
			'type'    => 'structure',
			'members' => [
				'Value' => [
					'shape'        => '__string',
					'locationName' => 'value',
				],
			],
		],
		'GetModelsRequest'                   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'      => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'GetModelsResponse'                  => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfModel',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetRouteRequest'                    => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'   => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'RouteId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
			],
			'required' => [ 'ApiId', 'RouteId', ],
		],
		'GetRouteResult'                     => [
			'type'    => 'structure',
			'members' => [
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteId'                          => [ 'shape' => 'Id', 'locationName' => 'routeId', ],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
		],
		'GetRouteResponseRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'           => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'RouteId'         => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
				'RouteResponseId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeResponseId',
				],
			],
			'required' => [ 'RouteResponseId', 'ApiId', 'RouteId', ],
		],
		'GetRouteResponseResponse'           => [
			'type'    => 'structure',
			'members' => [
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteResponseId'          => [
					'shape'        => 'Id',
					'locationName' => 'routeResponseId',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
		],
		'GetRouteResponsesRequest'           => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'      => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
				'RouteId'    => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
			],
			'required' => [ 'RouteId', 'ApiId', ],
		],
		'GetRouteResponsesResponse'          => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfRouteResponse',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetRoutesRequest'                   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'      => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'GetRoutesResponse'                  => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfRoute',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'GetStageRequest'                    => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'     => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'StageName' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'stageName',
				],
			],
			'required' => [ 'StageName', 'ApiId', ],
		],
		'GetStageResponse'                   => [
			'type'    => 'structure',
			'members' => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ClientCertificateId'  => [ 'shape' => 'Id', 'locationName' => 'clientCertificateId', ],
				'CreatedDate'          => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [ 'shape' => 'Id', 'locationName' => 'deploymentId', ],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'LastUpdatedDate'      => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'lastUpdatedDate',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageName'            => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
				'Tags'                 => [ 'shape' => 'Tags', 'locationName' => 'tags', ],
			],
		],
		'GetStagesRequest'                   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'      => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'MaxResults' => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'NextToken'  => [
					'shape'        => '__string',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'GetStagesResponse'                  => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfStage',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'Id'                                 => [ 'type' => 'string', ],
		'IdentitySourceList'                 => [ 'type' => 'list', 'member' => [ 'shape' => '__string', ], ],
		'IntegerWithLengthBetween0And3600'   => [ 'type' => 'integer', 'min' => 0, 'max' => 3600, ],
		'IntegerWithLengthBetween50And29000' => [ 'type' => 'integer', 'min' => 50, 'max' => 29000, ],
		'Integration'                        => [
			'type'    => 'structure',
			'members' => [
				'ConnectionId'                           => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'                         => [
					'shape'        => 'ConnectionType',
					'locationName' => 'connectionType',
				],
				'ContentHandlingStrategy'                => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'                         => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                            => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationId'                          => [ 'shape' => 'Id', 'locationName' => 'integrationId', ],
				'IntegrationMethod'                      => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'integrationResponseSelectionExpression',
				],
				'IntegrationType'                        => [
					'shape'        => 'IntegrationType',
					'locationName' => 'integrationType',
				],
				'IntegrationUri'                         => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'                    => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'                      => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'                       => [
					'shape'        => 'TemplateMap',
					'locationName' => 'requestTemplates',
				],
				'TemplateSelectionExpression'            => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'                        => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
		],
		'IntegrationParameters'              => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => 'StringWithLengthBetween1And512', ],
		],
		'IntegrationResponse'                => [
			'type'     => 'structure',
			'members'  => [
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationResponseId'       => [
					'shape'        => 'Id',
					'locationName' => 'integrationResponseId',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
			'required' => [ 'IntegrationResponseKey', ],
		],
		'IntegrationResponses'               => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfIntegrationResponse',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'IntegrationType'                    => [
			'type' => 'string',
			'enum' => [ 'AWS', 'HTTP', 'MOCK', 'HTTP_PROXY', 'AWS_PROXY', ],
		],
		'Integrations'                       => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfIntegration',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'LimitExceededException'             => [
			'type'    => 'structure',
			'members' => [
				'LimitType' => [
					'shape'        => '__string',
					'locationName' => 'limitType',
				],
				'Message'   => [
					'shape'        => '__string',
					'locationName' => 'message',
				],
			],
		],
		'GetTagsRequest'                     => [
			'type'     => 'structure',
			'members'  => [
				'ResourceArn' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'resource-arn',
				],
			],
			'required' => [ 'ResourceArn', ],
		],
		'GetTagsResponse'                    => [
			'type'    => 'structure',
			'members' => [
				'Tags' => [
					'shape'        => '__mapOf__string',
					'locationName' => 'tags',
				],
			],
		],
		'LoggingLevel'                       => [ 'type' => 'string', 'enum' => [ 'ERROR', 'INFO', 'false', ], ],
		'Model'                              => [
			'type'     => 'structure',
			'members'  => [
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'ModelId'     => [
					'shape'        => 'Id',
					'locationName' => 'modelId',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
			'required' => [ 'Name', ],
		],
		'Models'                             => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfModel',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'NextToken'                          => [ 'type' => 'string', ],
		'NotFoundException'                  => [
			'type'      => 'structure',
			'members'   => [
				'Message'      => [
					'shape'        => '__string',
					'locationName' => 'message',
				],
				'ResourceType' => [
					'shape'        => '__string',
					'locationName' => 'resourceType',
				],
			],
			'exception' => true,
			'error'     => [ 'httpStatusCode' => 404, ],
		],
		'ParameterConstraints'               => [
			'type'    => 'structure',
			'members' => [
				'Required' => [
					'shape'        => '__boolean',
					'locationName' => 'required',
				],
			],
		],
		'PassthroughBehavior'                => [
			'type' => 'string',
			'enum' => [ 'WHEN_NO_MATCH', 'NEVER', 'WHEN_NO_TEMPLATES', ],
		],
		'ProtocolType'                       => [ 'type' => 'string', 'enum' => [ 'WEBSOCKET', ], ],
		'ProviderArnList'                    => [ 'type' => 'list', 'member' => [ 'shape' => 'Arn', ], ],
		'Route'                              => [
			'type'     => 'structure',
			'members'  => [
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteId'                          => [ 'shape' => 'Id', 'locationName' => 'routeId', ],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
			'required' => [ 'RouteKey', ],
		],
		'RouteModels'                        => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => 'StringWithLengthBetween1And128', ],
		],
		'RouteParameters'                    => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => 'ParameterConstraints', ],
		],
		'RouteResponse'                      => [
			'type'     => 'structure',
			'members'  => [
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteResponseId'          => [
					'shape'        => 'Id',
					'locationName' => 'routeResponseId',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
			'required' => [ 'RouteResponseKey', ],
		],
		'RouteResponses'                     => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfRouteResponse',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'RouteSettings'                      => [
			'type'    => 'structure',
			'members' => [
				'DataTraceEnabled'       => [
					'shape'        => '__boolean',
					'locationName' => 'dataTraceEnabled',
				],
				'DetailedMetricsEnabled' => [
					'shape'        => '__boolean',
					'locationName' => 'detailedMetricsEnabled',
				],
				'LoggingLevel'           => [
					'shape'        => 'LoggingLevel',
					'locationName' => 'loggingLevel',
				],
				'ThrottlingBurstLimit'   => [
					'shape'        => '__integer',
					'locationName' => 'throttlingBurstLimit',
				],
				'ThrottlingRateLimit'    => [
					'shape'        => '__double',
					'locationName' => 'throttlingRateLimit',
				],
			],
		],
		'RouteSettingsMap'                   => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => 'RouteSettings', ],
		],
		'Routes'                             => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfRoute',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'SelectionExpression'                => [ 'type' => 'string', ],
		'SelectionKey'                       => [ 'type' => 'string', ],
		'Stage'                              => [
			'type'     => 'structure',
			'members'  => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ClientCertificateId'  => [ 'shape' => 'Id', 'locationName' => 'clientCertificateId', ],
				'CreatedDate'          => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [ 'shape' => 'Id', 'locationName' => 'deploymentId', ],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'LastUpdatedDate'      => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'lastUpdatedDate',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageName'            => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
				'Tags'                 => [ 'shape' => 'Tags', 'locationName' => 'tags', ],
			],
			'required' => [ 'StageName', ],
		],
		'StageVariablesMap'                  => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => 'StringWithLengthBetween0And2048', ],
		],
		'Stages'                             => [
			'type'    => 'structure',
			'members' => [
				'Items'     => [
					'shape'        => '__listOfStage',
					'locationName' => 'items',
				],
				'NextToken' => [
					'shape'        => 'NextToken',
					'locationName' => 'nextToken',
				],
			],
		],
		'StringWithLengthBetween0And1024'    => [ 'type' => 'string', ],
		'StringWithLengthBetween0And2048'    => [ 'type' => 'string', ],
		'StringWithLengthBetween0And32K'     => [ 'type' => 'string', ],
		'StringWithLengthBetween1And1024'    => [ 'type' => 'string', ],
		'StringWithLengthBetween1And128'     => [ 'type' => 'string', ],
		'StringWithLengthBetween1And256'     => [ 'type' => 'string', ],
		'StringWithLengthBetween1And512'     => [ 'type' => 'string', ],
		'StringWithLengthBetween1And64'      => [ 'type' => 'string', ],
		'StringWithLengthBetween1And1600'    => [
			'type'          => 'string',
			'documentation' => '<p>A string with a length between [1-1600].</p>',
		],
		'TagResourceInput'                   => [
			'type'    => 'structure',
			'members' => [
				'Tags' => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
		],
		'TagResourceRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ResourceArn' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'resource-arn',
				],
				'Tags'        => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
			'required' => [ 'ResourceArn', ],
		],
		'TagResourceResponse'                => [ 'type' => 'structure', 'members' => [], ],
		'Tags'                               => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => 'StringWithLengthBetween1And1600', ],
		],
		'UntagResourceRequest'               => [
			'type'     => 'structure',
			'members'  => [
				'ResourceArn' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'resource-arn',
				],
				'TagKeys'     => [
					'shape'        => '__listOf__string',
					'location'     => 'querystring',
					'locationName' => 'tagKeys',
				],
			],
			'required' => [ 'TagKeys', 'ResourceArn', ],
		],
		'Template'                           => [
			'type'    => 'structure',
			'members' => [
				'Value' => [
					'shape'        => '__string',
					'locationName' => 'value',
				],
			],
		],
		'TemplateMap'                        => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => 'StringWithLengthBetween0And32K', ],
		],
		'TooManyRequestsException'           => [
			'type'      => 'structure',
			'members'   => [
				'LimitType' => [
					'shape'        => '__string',
					'locationName' => 'limitType',
				],
				'Message'   => [
					'shape'        => '__string',
					'locationName' => 'message',
				],
			],
			'exception' => true,
			'error'     => [ 'httpStatusCode' => 429, ],
		],
		'UpdateApiInput'                     => [
			'type'    => 'structure',
			'members' => [
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [
					'shape'        => '__boolean',
					'locationName' => 'disableSchemaValidation',
				],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
			],
		],
		'UpdateApiMappingInput'              => [
			'type'    => 'structure',
			'members' => [
				'ApiId'         => [
					'shape'        => 'Id',
					'locationName' => 'apiId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
		],
		'UpdateApiMappingRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'         => [
					'shape'        => 'Id',
					'locationName' => 'apiId',
				],
				'ApiMappingId'  => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiMappingId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'DomainName'    => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
			'required' => [ 'ApiMappingId', 'ApiId', 'DomainName', ],
		],
		'UpdateApiMappingResponse'           => [
			'type'    => 'structure',
			'members' => [
				'ApiId'         => [
					'shape'        => 'Id',
					'locationName' => 'apiId',
				],
				'ApiMappingId'  => [
					'shape'        => 'Id',
					'locationName' => 'apiMappingId',
				],
				'ApiMappingKey' => [
					'shape'        => 'SelectionKey',
					'locationName' => 'apiMappingKey',
				],
				'Stage'         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stage',
				],
			],
		],
		'UpdateApiRequest'                   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                     => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [
					'shape'        => '__boolean',
					'locationName' => 'disableSchemaValidation',
				],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
			],
			'required' => [ 'ApiId', ],
		],
		'UpdateApiResponse'                  => [
			'type'    => 'structure',
			'members' => [
				'ApiEndpoint'               => [ 'shape' => '__string', 'locationName' => 'apiEndpoint', ],
				'ApiId'                     => [ 'shape' => 'Id', 'locationName' => 'apiId', ],
				'ApiKeySelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiKeySelectionExpression',
				],
				'CreatedDate'               => [ 'shape' => '__timestampIso8601', 'locationName' => 'createdDate', ],
				'Description'               => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'DisableSchemaValidation'   => [ 'shape' => '__boolean', 'locationName' => 'disableSchemaValidation', ],
				'Name'                      => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProtocolType'              => [ 'shape' => 'ProtocolType', 'locationName' => 'protocolType', ],
				'RouteSelectionExpression'  => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeSelectionExpression',
				],
				'Version'                   => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'version',
				],
				'Warnings'                  => [ 'shape' => '__listOf__string', 'locationName' => 'warnings', ],
				'Tags'                      => [ 'shape' => 'Tags', 'locationName' => 'tags', ],
			],
		],
		'UpdateAuthorizerInput'              => [
			'type'    => 'structure',
			'members' => [
				'AuthorizerCredentialsArn'     => [
					'shape'        => 'Arn',
					'locationName' => 'authorizerCredentialsArn',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [
					'shape'        => 'AuthorizerType',
					'locationName' => 'authorizerType',
				],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [
					'shape'        => 'ProviderArnList',
					'locationName' => 'providerArns',
				],
			],
		],
		'UpdateAuthorizerRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                        => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'AuthorizerCredentialsArn'     => [ 'shape' => 'Arn', 'locationName' => 'authorizerCredentialsArn', ],
				'AuthorizerId'                 => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'authorizerId',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [ 'shape' => 'AuthorizerType', 'locationName' => 'authorizerType', ],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [ 'shape' => 'ProviderArnList', 'locationName' => 'providerArns', ],
			],
			'required' => [ 'AuthorizerId', 'ApiId', ],
		],
		'UpdateAuthorizerResponse'           => [
			'type'    => 'structure',
			'members' => [
				'AuthorizerCredentialsArn'     => [
					'shape'        => 'Arn',
					'locationName' => 'authorizerCredentialsArn',
				],
				'AuthorizerId'                 => [
					'shape'        => 'Id',
					'locationName' => 'authorizerId',
				],
				'AuthorizerResultTtlInSeconds' => [
					'shape'        => 'IntegerWithLengthBetween0And3600',
					'locationName' => 'authorizerResultTtlInSeconds',
				],
				'AuthorizerType'               => [
					'shape'        => 'AuthorizerType',
					'locationName' => 'authorizerType',
				],
				'AuthorizerUri'                => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'authorizerUri',
				],
				'IdentitySource'               => [
					'shape'        => 'IdentitySourceList',
					'locationName' => 'identitySource',
				],
				'IdentityValidationExpression' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'identityValidationExpression',
				],
				'Name'                         => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'ProviderArns'                 => [
					'shape'        => 'ProviderArnList',
					'locationName' => 'providerArns',
				],
			],
		],
		'UpdateDeploymentInput'              => [
			'type'    => 'structure',
			'members' => [
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
			],
		],
		'UpdateDeploymentRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'        => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'DeploymentId' => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'deploymentId',
				],
				'Description'  => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
			],
			'required' => [ 'ApiId', 'DeploymentId', ],
		],
		'UpdateDeploymentResponse'           => [
			'type'    => 'structure',
			'members' => [
				'CreatedDate'             => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DeploymentId'            => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'DeploymentStatus'        => [
					'shape'        => 'DeploymentStatus',
					'locationName' => 'deploymentStatus',
				],
				'DeploymentStatusMessage' => [
					'shape'        => '__string',
					'locationName' => 'deploymentStatusMessage',
				],
				'Description'             => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
			],
		],
		'UpdateDomainNameInput'              => [
			'type'    => 'structure',
			'members' => [
				'DomainNameConfigurations' => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
			],
		],
		'UpdateDomainNameRequest'            => [
			'type'     => 'structure',
			'members'  => [
				'DomainName'               => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'domainName',
				],
				'DomainNameConfigurations' => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
			],
			'required' => [ 'DomainName', ],
		],
		'UpdateDomainNameResponse'           => [
			'type'    => 'structure',
			'members' => [
				'ApiMappingSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'apiMappingSelectionExpression',
				],
				'DomainName'                    => [
					'shape'        => 'StringWithLengthBetween1And512',
					'locationName' => 'domainName',
				],
				'DomainNameConfigurations'      => [
					'shape'        => 'DomainNameConfigurations',
					'locationName' => 'domainNameConfigurations',
				],
				'Tags'                          => [
					'shape'        => 'Tags',
					'locationName' => 'tags',
				],
			],
		],
		'UpdateIntegrationInput'             => [
			'type'    => 'structure',
			'members' => [
				'ConnectionId'                => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'              => [ 'shape' => 'ConnectionType', 'locationName' => 'connectionType', ],
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'              => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                 => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationMethod'           => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationType'             => [ 'shape' => 'IntegrationType', 'locationName' => 'integrationType', ],
				'IntegrationUri'              => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'         => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'           => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'            => [ 'shape' => 'TemplateMap', 'locationName' => 'requestTemplates', ],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'             => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
		],
		'UpdateIntegrationRequest'           => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ConnectionId'                => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'              => [ 'shape' => 'ConnectionType', 'locationName' => 'connectionType', ],
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'              => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                 => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationId'               => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
				'IntegrationMethod'           => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationType'             => [ 'shape' => 'IntegrationType', 'locationName' => 'integrationType', ],
				'IntegrationUri'              => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'         => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'           => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'            => [ 'shape' => 'TemplateMap', 'locationName' => 'requestTemplates', ],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'             => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
			'required' => [ 'ApiId', 'IntegrationId', ],
		],
		'UpdateIntegrationResult'            => [
			'type'    => 'structure',
			'members' => [
				'ConnectionId'                           => [
					'shape'        => 'StringWithLengthBetween1And1024',
					'locationName' => 'connectionId',
				],
				'ConnectionType'                         => [
					'shape'        => 'ConnectionType',
					'locationName' => 'connectionType',
				],
				'ContentHandlingStrategy'                => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'CredentialsArn'                         => [ 'shape' => 'Arn', 'locationName' => 'credentialsArn', ],
				'Description'                            => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'IntegrationId'                          => [ 'shape' => 'Id', 'locationName' => 'integrationId', ],
				'IntegrationMethod'                      => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'integrationMethod',
				],
				'IntegrationResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'integrationResponseSelectionExpression',
				],
				'IntegrationType'                        => [
					'shape'        => 'IntegrationType',
					'locationName' => 'integrationType',
				],
				'IntegrationUri'                         => [
					'shape'        => 'UriWithLengthBetween1And2048',
					'locationName' => 'integrationUri',
				],
				'PassthroughBehavior'                    => [
					'shape'        => 'PassthroughBehavior',
					'locationName' => 'passthroughBehavior',
				],
				'RequestParameters'                      => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'requestParameters',
				],
				'RequestTemplates'                       => [
					'shape'        => 'TemplateMap',
					'locationName' => 'requestTemplates',
				],
				'TemplateSelectionExpression'            => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
				'TimeoutInMillis'                        => [
					'shape'        => 'IntegerWithLengthBetween50And29000',
					'locationName' => 'timeoutInMillis',
				],
			],
		],
		'UpdateIntegrationResponseInput'     => [
			'type'    => 'structure',
			'members' => [
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
		],
		'UpdateIntegrationResponseRequest'   => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationId'               => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationId',
				],
				'IntegrationResponseId'       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'integrationResponseId',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
			'required' => [ 'ApiId', 'IntegrationResponseId', 'IntegrationId', ],
		],
		'UpdateIntegrationResponseResponse'  => [
			'type'    => 'structure',
			'members' => [
				'ContentHandlingStrategy'     => [
					'shape'        => 'ContentHandlingStrategy',
					'locationName' => 'contentHandlingStrategy',
				],
				'IntegrationResponseId'       => [
					'shape'        => 'Id',
					'locationName' => 'integrationResponseId',
				],
				'IntegrationResponseKey'      => [
					'shape'        => 'SelectionKey',
					'locationName' => 'integrationResponseKey',
				],
				'ResponseParameters'          => [
					'shape'        => 'IntegrationParameters',
					'locationName' => 'responseParameters',
				],
				'ResponseTemplates'           => [
					'shape'        => 'TemplateMap',
					'locationName' => 'responseTemplates',
				],
				'TemplateSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'templateSelectionExpression',
				],
			],
		],
		'UpdateModelInput'                   => [
			'type'    => 'structure',
			'members' => [
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
		],
		'UpdateModelRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'       => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'ModelId'     => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'modelId',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
			'required' => [ 'ModelId', 'ApiId', ],
		],
		'UpdateModelResponse'                => [
			'type'    => 'structure',
			'members' => [
				'ContentType' => [
					'shape'        => 'StringWithLengthBetween1And256',
					'locationName' => 'contentType',
				],
				'Description' => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'ModelId'     => [
					'shape'        => 'Id',
					'locationName' => 'modelId',
				],
				'Name'        => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'name',
				],
				'Schema'      => [
					'shape'        => 'StringWithLengthBetween0And32K',
					'locationName' => 'schema',
				],
			],
		],
		'UpdateRouteInput'                   => [
			'type'    => 'structure',
			'members' => [
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
		],
		'UpdateRouteRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                            => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteId'                          => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
			'required' => [ 'ApiId', 'RouteId', ],
		],
		'UpdateRouteResult'                  => [
			'type'    => 'structure',
			'members' => [
				'ApiKeyRequired'                   => [ 'shape' => '__boolean', 'locationName' => 'apiKeyRequired', ],
				'AuthorizationScopes'              => [
					'shape'        => 'AuthorizationScopes',
					'locationName' => 'authorizationScopes',
				],
				'AuthorizationType'                => [
					'shape'        => 'AuthorizationType',
					'locationName' => 'authorizationType',
				],
				'AuthorizerId'                     => [ 'shape' => 'Id', 'locationName' => 'authorizerId', ],
				'ModelSelectionExpression'         => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'OperationName'                    => [
					'shape'        => 'StringWithLengthBetween1And64',
					'locationName' => 'operationName',
				],
				'RequestModels'                    => [ 'shape' => 'RouteModels', 'locationName' => 'requestModels', ],
				'RequestParameters'                => [
					'shape'        => 'RouteParameters',
					'locationName' => 'requestParameters',
				],
				'RouteId'                          => [ 'shape' => 'Id', 'locationName' => 'routeId', ],
				'RouteKey'                         => [ 'shape' => 'SelectionKey', 'locationName' => 'routeKey', ],
				'RouteResponseSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'routeResponseSelectionExpression',
				],
				'Target'                           => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'target',
				],
			],
		],
		'UpdateRouteResponseInput'           => [
			'type'    => 'structure',
			'members' => [
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
		],
		'UpdateRouteResponseRequest'         => [
			'type'     => 'structure',
			'members'  => [
				'ApiId'                    => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteId'                  => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeId',
				],
				'RouteResponseId'          => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'routeResponseId',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
			'required' => [ 'RouteResponseId', 'ApiId', 'RouteId', ],
		],
		'UpdateRouteResponseResponse'        => [
			'type'    => 'structure',
			'members' => [
				'ModelSelectionExpression' => [
					'shape'        => 'SelectionExpression',
					'locationName' => 'modelSelectionExpression',
				],
				'ResponseModels'           => [
					'shape'        => 'RouteModels',
					'locationName' => 'responseModels',
				],
				'ResponseParameters'       => [
					'shape'        => 'RouteParameters',
					'locationName' => 'responseParameters',
				],
				'RouteResponseId'          => [
					'shape'        => 'Id',
					'locationName' => 'routeResponseId',
				],
				'RouteResponseKey'         => [
					'shape'        => 'SelectionKey',
					'locationName' => 'routeResponseKey',
				],
			],
		],
		'UpdateStageInput'                   => [
			'type'    => 'structure',
			'members' => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ClientCertificateId'  => [
					'shape'        => 'Id',
					'locationName' => 'clientCertificateId',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
			],
		],
		'UpdateStageRequest'                 => [
			'type'     => 'structure',
			'members'  => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ApiId'                => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'apiId',
				],
				'ClientCertificateId'  => [
					'shape'        => 'Id',
					'locationName' => 'clientCertificateId',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [
					'shape'        => 'Id',
					'locationName' => 'deploymentId',
				],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageName'            => [
					'shape'        => '__string',
					'location'     => 'uri',
					'locationName' => 'stageName',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
			],
			'required' => [ 'StageName', 'ApiId', ],
		],
		'UpdateStageResponse'                => [
			'type'    => 'structure',
			'members' => [
				'AccessLogSettings'    => [
					'shape'        => 'AccessLogSettings',
					'locationName' => 'accessLogSettings',
				],
				'ClientCertificateId'  => [ 'shape' => 'Id', 'locationName' => 'clientCertificateId', ],
				'CreatedDate'          => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'createdDate',
				],
				'DefaultRouteSettings' => [
					'shape'        => 'RouteSettings',
					'locationName' => 'defaultRouteSettings',
				],
				'DeploymentId'         => [ 'shape' => 'Id', 'locationName' => 'deploymentId', ],
				'Description'          => [
					'shape'        => 'StringWithLengthBetween0And1024',
					'locationName' => 'description',
				],
				'LastUpdatedDate'      => [
					'shape'        => '__timestampIso8601',
					'locationName' => 'lastUpdatedDate',
				],
				'RouteSettings'        => [
					'shape'        => 'RouteSettingsMap',
					'locationName' => 'routeSettings',
				],
				'StageName'            => [
					'shape'        => 'StringWithLengthBetween1And128',
					'locationName' => 'stageName',
				],
				'StageVariables'       => [
					'shape'        => 'StageVariablesMap',
					'locationName' => 'stageVariables',
				],
				'Tags'                 => [ 'shape' => 'Tags', 'locationName' => 'tags', ],
			],
		],
		'UriWithLengthBetween1And2048'       => [ 'type' => 'string', ],
		'__boolean'                          => [ 'type' => 'boolean', ],
		'__double'                           => [ 'type' => 'double', ],
		'__integer'                          => [ 'type' => 'integer', ],
		'__listOfApi'                        => [ 'type' => 'list', 'member' => [ 'shape' => 'Api', ], ],
		'__listOfApiMapping'                 => [ 'type' => 'list', 'member' => [ 'shape' => 'ApiMapping', ], ],
		'__listOfAuthorizer'                 => [ 'type' => 'list', 'member' => [ 'shape' => 'Authorizer', ], ],
		'__listOfDeployment'                 => [ 'type' => 'list', 'member' => [ 'shape' => 'Deployment', ], ],
		'__listOfDomainName'                 => [ 'type' => 'list', 'member' => [ 'shape' => 'DomainName', ], ],
		'__listOfIntegration'                => [ 'type' => 'list', 'member' => [ 'shape' => 'Integration', ], ],
		'__listOfIntegrationResponse'        => [
			'type'   => 'list',
			'member' => [ 'shape' => 'IntegrationResponse', ],
		],
		'__listOfModel'                      => [ 'type' => 'list', 'member' => [ 'shape' => 'Model', ], ],
		'__listOfRoute'                      => [ 'type' => 'list', 'member' => [ 'shape' => 'Route', ], ],
		'__listOfRouteResponse'              => [ 'type' => 'list', 'member' => [ 'shape' => 'RouteResponse', ], ],
		'__listOfStage'                      => [ 'type' => 'list', 'member' => [ 'shape' => 'Stage', ], ],
		'__listOf__string'                   => [ 'type' => 'list', 'member' => [ 'shape' => '__string', ], ],
		'__long'                             => [ 'type' => 'long', ],
		'__string'                           => [ 'type' => 'string', ],
		'__mapOf__string'                    => [
			'type'  => 'map',
			'key'   => [ 'shape' => '__string', ],
			'value' => [ 'shape' => '__string', ],
		],
		'__timestampIso8601'                 => [ 'type' => 'timestamp', 'timestampFormat' => 'iso8601', ],
		'__timestampUnix'                    => [ 'type' => 'timestamp', 'timestampFormat' => 'unixTimestamp', ],
	],
	'authorizers' => [
		'authorization_strategy' => [
			'name'      => 'authorization_strategy',
			'type'      => 'provided',
			'placement' => [
				'location' => 'header',
				'name'     => 'Authorization',
			],
		],
	],
];
