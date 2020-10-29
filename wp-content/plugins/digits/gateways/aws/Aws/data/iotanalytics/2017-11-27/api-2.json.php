<?php
// This file was auto-generated from sdk-root/src/data/iotanalytics/2017-11-27/api-2.json
return [
	'version'    => '2.0',
	'metadata'   => [
		'apiVersion'       => '2017-11-27',
		'endpointPrefix'   => 'iotanalytics',
		'protocol'         => 'rest-json',
		'serviceFullName'  => 'AWS IoT Analytics',
		'serviceId'        => 'IoTAnalytics',
		'signatureVersion' => 'v4',
		'signingName'      => 'iotanalytics',
		'uid'              => 'iotanalytics-2017-11-27',
	],
	'operations' => [
		'BatchPutMessage'            => [
			'name'   => 'BatchPutMessage',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/messages/batch',
				'responseCode' => 200,
			],
			'input'  => [ 'shape' => 'BatchPutMessageRequest', ],
			'output' => [ 'shape' => 'BatchPutMessageResponse', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'CancelPipelineReprocessing' => [
			'name'   => 'CancelPipelineReprocessing',
			'http'   => [
				'method'     => 'DELETE',
				'requestUri' => '/pipelines/{pipelineName}/reprocessing/{reprocessingId}',
			],
			'input'  => [ 'shape' => 'CancelPipelineReprocessingRequest', ],
			'output' => [ 'shape' => 'CancelPipelineReprocessingResponse', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'CreateChannel'              => [
			'name'   => 'CreateChannel',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/channels',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateChannelRequest', ],
			'output' => [ 'shape' => 'CreateChannelResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceAlreadyExistsException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'CreateDataset'              => [
			'name'   => 'CreateDataset',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/datasets',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateDatasetRequest', ],
			'output' => [ 'shape' => 'CreateDatasetResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceAlreadyExistsException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'CreateDatasetContent'       => [
			'name'   => 'CreateDatasetContent',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/datasets/{datasetName}/content',
			],
			'input'  => [ 'shape' => 'CreateDatasetContentRequest', ],
			'output' => [ 'shape' => 'CreateDatasetContentResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'CreateDatastore'            => [
			'name'   => 'CreateDatastore',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/datastores',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreateDatastoreRequest', ],
			'output' => [ 'shape' => 'CreateDatastoreResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceAlreadyExistsException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'CreatePipeline'             => [
			'name'   => 'CreatePipeline',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/pipelines',
				'responseCode' => 201,
			],
			'input'  => [ 'shape' => 'CreatePipelineRequest', ],
			'output' => [ 'shape' => 'CreatePipelineResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceAlreadyExistsException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'DeleteChannel'              => [
			'name'   => 'DeleteChannel',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/channels/{channelName}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteChannelRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DeleteDataset'              => [
			'name'   => 'DeleteDataset',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/datasets/{datasetName}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteDatasetRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DeleteDatasetContent'       => [
			'name'   => 'DeleteDatasetContent',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/datasets/{datasetName}/content',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteDatasetContentRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DeleteDatastore'            => [
			'name'   => 'DeleteDatastore',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/datastores/{datastoreName}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeleteDatastoreRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DeletePipeline'             => [
			'name'   => 'DeletePipeline',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/pipelines/{pipelineName}',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'DeletePipelineRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DescribeChannel'            => [
			'name'   => 'DescribeChannel',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/channels/{channelName}', ],
			'input'  => [ 'shape' => 'DescribeChannelRequest', ],
			'output' => [ 'shape' => 'DescribeChannelResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DescribeDataset'            => [
			'name'   => 'DescribeDataset',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/datasets/{datasetName}', ],
			'input'  => [ 'shape' => 'DescribeDatasetRequest', ],
			'output' => [ 'shape' => 'DescribeDatasetResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DescribeDatastore'          => [
			'name'   => 'DescribeDatastore',
			'http'   => [
				'method'     => 'GET',
				'requestUri' => '/datastores/{datastoreName}',
			],
			'input'  => [ 'shape' => 'DescribeDatastoreRequest', ],
			'output' => [ 'shape' => 'DescribeDatastoreResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DescribeLoggingOptions'     => [
			'name'   => 'DescribeLoggingOptions',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/logging', ],
			'input'  => [ 'shape' => 'DescribeLoggingOptionsRequest', ],
			'output' => [ 'shape' => 'DescribeLoggingOptionsResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'DescribePipeline'           => [
			'name'   => 'DescribePipeline',
			'http'   => [
				'method'     => 'GET',
				'requestUri' => '/pipelines/{pipelineName}',
			],
			'input'  => [ 'shape' => 'DescribePipelineRequest', ],
			'output' => [ 'shape' => 'DescribePipelineResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'GetDatasetContent'          => [
			'name'   => 'GetDatasetContent',
			'http'   => [
				'method'     => 'GET',
				'requestUri' => '/datasets/{datasetName}/content',
			],
			'input'  => [ 'shape' => 'GetDatasetContentRequest', ],
			'output' => [ 'shape' => 'GetDatasetContentResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'ListChannels'               => [
			'name'   => 'ListChannels',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/channels', ],
			'input'  => [ 'shape' => 'ListChannelsRequest', ],
			'output' => [ 'shape' => 'ListChannelsResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'ListDatasetContents'        => [
			'name'   => 'ListDatasetContents',
			'http'   => [
				'method'     => 'GET',
				'requestUri' => '/datasets/{datasetName}/contents',
			],
			'input'  => [ 'shape' => 'ListDatasetContentsRequest', ],
			'output' => [ 'shape' => 'ListDatasetContentsResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'ListDatasets'               => [
			'name'   => 'ListDatasets',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/datasets', ],
			'input'  => [ 'shape' => 'ListDatasetsRequest', ],
			'output' => [ 'shape' => 'ListDatasetsResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'ListDatastores'             => [
			'name'   => 'ListDatastores',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/datastores', ],
			'input'  => [ 'shape' => 'ListDatastoresRequest', ],
			'output' => [ 'shape' => 'ListDatastoresResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'ListPipelines'              => [
			'name'   => 'ListPipelines',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/pipelines', ],
			'input'  => [ 'shape' => 'ListPipelinesRequest', ],
			'output' => [ 'shape' => 'ListPipelinesResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'ListTagsForResource'        => [
			'name'   => 'ListTagsForResource',
			'http'   => [ 'method' => 'GET', 'requestUri' => '/tags', ],
			'input'  => [ 'shape' => 'ListTagsForResourceRequest', ],
			'output' => [ 'shape' => 'ListTagsForResourceResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'PutLoggingOptions'          => [
			'name'   => 'PutLoggingOptions',
			'http'   => [ 'method' => 'PUT', 'requestUri' => '/logging', ],
			'input'  => [ 'shape' => 'PutLoggingOptionsRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'RunPipelineActivity'        => [
			'name'   => 'RunPipelineActivity',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/pipelineactivities/run',
			],
			'input'  => [ 'shape' => 'RunPipelineActivityRequest', ],
			'output' => [ 'shape' => 'RunPipelineActivityResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'SampleChannelData'          => [
			'name'   => 'SampleChannelData',
			'http'   => [
				'method'     => 'GET',
				'requestUri' => '/channels/{channelName}/sample',
			],
			'input'  => [ 'shape' => 'SampleChannelDataRequest', ],
			'output' => [ 'shape' => 'SampleChannelDataResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'StartPipelineReprocessing'  => [
			'name'   => 'StartPipelineReprocessing',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/pipelines/{pipelineName}/reprocessing',
			],
			'input'  => [ 'shape' => 'StartPipelineReprocessingRequest', ],
			'output' => [ 'shape' => 'StartPipelineReprocessingResponse', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'ResourceAlreadyExistsException', ],
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'TagResource'                => [
			'name'   => 'TagResource',
			'http'   => [
				'method'       => 'POST',
				'requestUri'   => '/tags',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'TagResourceRequest', ],
			'output' => [ 'shape' => 'TagResourceResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'UntagResource'              => [
			'name'   => 'UntagResource',
			'http'   => [
				'method'       => 'DELETE',
				'requestUri'   => '/tags',
				'responseCode' => 204,
			],
			'input'  => [ 'shape' => 'UntagResourceRequest', ],
			'output' => [ 'shape' => 'UntagResourceResponse', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'UpdateChannel'              => [
			'name'   => 'UpdateChannel',
			'http'   => [ 'method' => 'PUT', 'requestUri' => '/channels/{channelName}', ],
			'input'  => [ 'shape' => 'UpdateChannelRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'UpdateDataset'              => [
			'name'   => 'UpdateDataset',
			'http'   => [ 'method' => 'PUT', 'requestUri' => '/datasets/{datasetName}', ],
			'input'  => [ 'shape' => 'UpdateDatasetRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'UpdateDatastore'            => [
			'name'   => 'UpdateDatastore',
			'http'   => [
				'method'     => 'PUT',
				'requestUri' => '/datastores/{datastoreName}',
			],
			'input'  => [ 'shape' => 'UpdateDatastoreRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
			],
		],
		'UpdatePipeline'             => [
			'name'   => 'UpdatePipeline',
			'http'   => [
				'method'     => 'PUT',
				'requestUri' => '/pipelines/{pipelineName}',
			],
			'input'  => [ 'shape' => 'UpdatePipelineRequest', ],
			'errors' => [
				[ 'shape' => 'InvalidRequestException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InternalFailureException', ],
				[ 'shape' => 'ServiceUnavailableException', ],
				[ 'shape' => 'ThrottlingException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
	],
	'shapes'     => [
		'ActivityBatchSize'                        => [ 'type' => 'integer', 'max' => 1000, 'min' => 1, ],
		'ActivityName'                             => [ 'type' => 'string', 'max' => 128, 'min' => 1, ],
		'AddAttributesActivity'                    => [
			'type'     => 'structure',
			'required' => [ 'name', 'attributes', ],
			'members'  => [
				'name'       => [ 'shape' => 'ActivityName', ],
				'attributes' => [ 'shape' => 'AttributeNameMapping', ],
				'next'       => [ 'shape' => 'ActivityName', ],
			],
		],
		'AttributeName'                            => [ 'type' => 'string', 'max' => 256, 'min' => 1, ],
		'AttributeNameMapping'                     => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'AttributeName', ],
			'value' => [ 'shape' => 'AttributeName', ],
			'max'   => 50,
			'min'   => 1,
		],
		'AttributeNames'                           => [
			'type'   => 'list',
			'member' => [ 'shape' => 'AttributeName', ],
			'max'    => 50,
			'min'    => 1,
		],
		'BatchPutMessageErrorEntries'              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'BatchPutMessageErrorEntry', ],
		],
		'BatchPutMessageErrorEntry'                => [
			'type'    => 'structure',
			'members' => [
				'messageId'    => [ 'shape' => 'MessageId', ],
				'errorCode'    => [ 'shape' => 'ErrorCode', ],
				'errorMessage' => [ 'shape' => 'ErrorMessage', ],
			],
		],
		'BatchPutMessageRequest'                   => [
			'type'     => 'structure',
			'required' => [ 'channelName', 'messages', ],
			'members'  => [
				'channelName' => [ 'shape' => 'ChannelName', ],
				'messages'    => [ 'shape' => 'Messages', ],
			],
		],
		'BatchPutMessageResponse'                  => [
			'type'    => 'structure',
			'members' => [ 'batchPutMessageErrorEntries' => [ 'shape' => 'BatchPutMessageErrorEntries', ], ],
		],
		'BucketKeyExpression'                      => [
			'type'    => 'string',
			'max'     => 255,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9!_.*\'()/{}:-]*$',
		],
		'BucketName'                               => [
			'type'    => 'string',
			'max'     => 255,
			'min'     => 3,
			'pattern' => '^[a-zA-Z0-9.\\-_]*$',
		],
		'CancelPipelineReprocessingRequest'        => [
			'type'     => 'structure',
			'required' => [ 'pipelineName', 'reprocessingId', ],
			'members'  => [
				'pipelineName'   => [
					'shape'        => 'PipelineName',
					'location'     => 'uri',
					'locationName' => 'pipelineName',
				],
				'reprocessingId' => [
					'shape'        => 'ReprocessingId',
					'location'     => 'uri',
					'locationName' => 'reprocessingId',
				],
			],
		],
		'CancelPipelineReprocessingResponse'       => [ 'type' => 'structure', 'members' => [], ],
		'Channel'                                  => [
			'type'    => 'structure',
			'members' => [
				'name'            => [ 'shape' => 'ChannelName', ],
				'storage'         => [ 'shape' => 'ChannelStorage', ],
				'arn'             => [ 'shape' => 'ChannelArn', ],
				'status'          => [ 'shape' => 'ChannelStatus', ],
				'retentionPeriod' => [ 'shape' => 'RetentionPeriod', ],
				'creationTime'    => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime'  => [ 'shape' => 'Timestamp', ],
			],
		],
		'ChannelActivity'                          => [
			'type'     => 'structure',
			'required' => [ 'name', 'channelName', ],
			'members'  => [
				'name'        => [ 'shape' => 'ActivityName', ],
				'channelName' => [ 'shape' => 'ChannelName', ],
				'next'        => [ 'shape' => 'ActivityName', ],
			],
		],
		'ChannelArn'                               => [ 'type' => 'string', ],
		'ChannelName'                              => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_]+$',
		],
		'ChannelStatistics'                        => [
			'type'    => 'structure',
			'members' => [ 'size' => [ 'shape' => 'EstimatedResourceSize', ], ],
		],
		'ChannelStatus'                            => [
			'type' => 'string',
			'enum' => [ 'CREATING', 'ACTIVE', 'DELETING', ],
		],
		'ChannelStorage'                           => [
			'type'    => 'structure',
			'members' => [
				'serviceManagedS3'  => [ 'shape' => 'ServiceManagedChannelS3Storage', ],
				'customerManagedS3' => [ 'shape' => 'CustomerManagedChannelS3Storage', ],
			],
		],
		'ChannelStorageSummary'                    => [
			'type'    => 'structure',
			'members' => [
				'serviceManagedS3'  => [ 'shape' => 'ServiceManagedChannelS3StorageSummary', ],
				'customerManagedS3' => [ 'shape' => 'CustomerManagedChannelS3StorageSummary', ],
			],
		],
		'ChannelSummaries'                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ChannelSummary', ],
		],
		'ChannelSummary'                           => [
			'type'    => 'structure',
			'members' => [
				'channelName'    => [ 'shape' => 'ChannelName', ],
				'channelStorage' => [ 'shape' => 'ChannelStorageSummary', ],
				'status'         => [ 'shape' => 'ChannelStatus', ],
				'creationTime'   => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime' => [ 'shape' => 'Timestamp', ],
			],
		],
		'ComputeType'                              => [ 'type' => 'string', 'enum' => [ 'ACU_1', 'ACU_2', ], ],
		'ContainerDatasetAction'                   => [
			'type'     => 'structure',
			'required' => [
				'image',
				'executionRoleArn',
				'resourceConfiguration',
			],
			'members'  => [
				'image'                 => [ 'shape' => 'Image', ],
				'executionRoleArn'      => [ 'shape' => 'RoleArn', ],
				'resourceConfiguration' => [ 'shape' => 'ResourceConfiguration', ],
				'variables'             => [ 'shape' => 'Variables', ],
			],
		],
		'CreateChannelRequest'                     => [
			'type'     => 'structure',
			'required' => [ 'channelName', ],
			'members'  => [
				'channelName'     => [ 'shape' => 'ChannelName', ],
				'channelStorage'  => [ 'shape' => 'ChannelStorage', ],
				'retentionPeriod' => [ 'shape' => 'RetentionPeriod', ],
				'tags'            => [ 'shape' => 'TagList', ],
			],
		],
		'CreateChannelResponse'                    => [
			'type'    => 'structure',
			'members' => [
				'channelName'     => [ 'shape' => 'ChannelName', ],
				'channelArn'      => [ 'shape' => 'ChannelArn', ],
				'retentionPeriod' => [ 'shape' => 'RetentionPeriod', ],
			],
		],
		'CreateDatasetContentRequest'              => [
			'type'     => 'structure',
			'required' => [ 'datasetName', ],
			'members'  => [
				'datasetName' => [
					'shape'        => 'DatasetName',
					'location'     => 'uri',
					'locationName' => 'datasetName',
				],
			],
		],
		'CreateDatasetContentResponse'             => [
			'type'    => 'structure',
			'members' => [ 'versionId' => [ 'shape' => 'DatasetContentVersion', ], ],
		],
		'CreateDatasetRequest'                     => [
			'type'     => 'structure',
			'required' => [ 'datasetName', 'actions', ],
			'members'  => [
				'datasetName'             => [ 'shape' => 'DatasetName', ],
				'actions'                 => [ 'shape' => 'DatasetActions', ],
				'triggers'                => [ 'shape' => 'DatasetTriggers', ],
				'contentDeliveryRules'    => [ 'shape' => 'DatasetContentDeliveryRules', ],
				'retentionPeriod'         => [ 'shape' => 'RetentionPeriod', ],
				'versioningConfiguration' => [ 'shape' => 'VersioningConfiguration', ],
				'tags'                    => [ 'shape' => 'TagList', ],
			],
		],
		'CreateDatasetResponse'                    => [
			'type'    => 'structure',
			'members' => [
				'datasetName'     => [ 'shape' => 'DatasetName', ],
				'datasetArn'      => [ 'shape' => 'DatasetArn', ],
				'retentionPeriod' => [ 'shape' => 'RetentionPeriod', ],
			],
		],
		'CreateDatastoreRequest'                   => [
			'type'     => 'structure',
			'required' => [ 'datastoreName', ],
			'members'  => [
				'datastoreName'    => [ 'shape' => 'DatastoreName', ],
				'datastoreStorage' => [ 'shape' => 'DatastoreStorage', ],
				'retentionPeriod'  => [ 'shape' => 'RetentionPeriod', ],
				'tags'             => [ 'shape' => 'TagList', ],
			],
		],
		'CreateDatastoreResponse'                  => [
			'type'    => 'structure',
			'members' => [
				'datastoreName'   => [ 'shape' => 'DatastoreName', ],
				'datastoreArn'    => [ 'shape' => 'DatastoreArn', ],
				'retentionPeriod' => [ 'shape' => 'RetentionPeriod', ],
			],
		],
		'CreatePipelineRequest'                    => [
			'type'     => 'structure',
			'required' => [ 'pipelineName', 'pipelineActivities', ],
			'members'  => [
				'pipelineName'       => [ 'shape' => 'PipelineName', ],
				'pipelineActivities' => [ 'shape' => 'PipelineActivities', ],
				'tags'               => [ 'shape' => 'TagList', ],
			],
		],
		'CreatePipelineResponse'                   => [
			'type'    => 'structure',
			'members' => [
				'pipelineName' => [ 'shape' => 'PipelineName', ],
				'pipelineArn'  => [ 'shape' => 'PipelineArn', ],
			],
		],
		'CustomerManagedChannelS3Storage'          => [
			'type'     => 'structure',
			'required' => [ 'bucket', 'roleArn', ],
			'members'  => [
				'bucket'    => [ 'shape' => 'BucketName', ],
				'keyPrefix' => [ 'shape' => 'S3KeyPrefix', ],
				'roleArn'   => [ 'shape' => 'RoleArn', ],
			],
		],
		'CustomerManagedChannelS3StorageSummary'   => [
			'type'    => 'structure',
			'members' => [
				'bucket'    => [ 'shape' => 'BucketName', ],
				'keyPrefix' => [ 'shape' => 'S3KeyPrefix', ],
				'roleArn'   => [ 'shape' => 'RoleArn', ],
			],
		],
		'CustomerManagedDatastoreS3Storage'        => [
			'type'     => 'structure',
			'required' => [ 'bucket', 'roleArn', ],
			'members'  => [
				'bucket'    => [ 'shape' => 'BucketName', ],
				'keyPrefix' => [ 'shape' => 'S3KeyPrefix', ],
				'roleArn'   => [ 'shape' => 'RoleArn', ],
			],
		],
		'CustomerManagedDatastoreS3StorageSummary' => [
			'type'    => 'structure',
			'members' => [
				'bucket'    => [ 'shape' => 'BucketName', ],
				'keyPrefix' => [ 'shape' => 'S3KeyPrefix', ],
				'roleArn'   => [ 'shape' => 'RoleArn', ],
			],
		],
		'Dataset'                                  => [
			'type'    => 'structure',
			'members' => [
				'name'                    => [ 'shape' => 'DatasetName', ],
				'arn'                     => [ 'shape' => 'DatasetArn', ],
				'actions'                 => [ 'shape' => 'DatasetActions', ],
				'triggers'                => [ 'shape' => 'DatasetTriggers', ],
				'contentDeliveryRules'    => [ 'shape' => 'DatasetContentDeliveryRules', ],
				'status'                  => [ 'shape' => 'DatasetStatus', ],
				'creationTime'            => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime'          => [ 'shape' => 'Timestamp', ],
				'retentionPeriod'         => [ 'shape' => 'RetentionPeriod', ],
				'versioningConfiguration' => [ 'shape' => 'VersioningConfiguration', ],
			],
		],
		'DatasetAction'                            => [
			'type'    => 'structure',
			'members' => [
				'actionName'      => [ 'shape' => 'DatasetActionName', ],
				'queryAction'     => [ 'shape' => 'SqlQueryDatasetAction', ],
				'containerAction' => [ 'shape' => 'ContainerDatasetAction', ],
			],
		],
		'DatasetActionName'                        => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_]+$',
		],
		'DatasetActionSummaries'                   => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DatasetActionSummary', ],
			'max'    => 1,
			'min'    => 1,
		],
		'DatasetActionSummary'                     => [
			'type'    => 'structure',
			'members' => [
				'actionName' => [ 'shape' => 'DatasetActionName', ],
				'actionType' => [ 'shape' => 'DatasetActionType', ],
			],
		],
		'DatasetActionType'                        => [ 'type' => 'string', 'enum' => [ 'QUERY', 'CONTAINER', ], ],
		'DatasetActions'                           => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DatasetAction', ],
			'max'    => 1,
			'min'    => 1,
		],
		'DatasetArn'                               => [ 'type' => 'string', ],
		'DatasetContentDeliveryDestination'        => [
			'type'    => 'structure',
			'members' => [
				'iotEventsDestinationConfiguration' => [ 'shape' => 'IotEventsDestinationConfiguration', ],
				's3DestinationConfiguration'        => [ 'shape' => 'S3DestinationConfiguration', ],
			],
		],
		'DatasetContentDeliveryRule'               => [
			'type'     => 'structure',
			'required' => [ 'destination', ],
			'members'  => [
				'entryName'   => [ 'shape' => 'EntryName', ],
				'destination' => [ 'shape' => 'DatasetContentDeliveryDestination', ],
			],
		],
		'DatasetContentDeliveryRules'              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DatasetContentDeliveryRule', ],
			'max'    => 20,
			'min'    => 0,
		],
		'DatasetContentState'                      => [
			'type' => 'string',
			'enum' => [ 'CREATING', 'SUCCEEDED', 'FAILED', ],
		],
		'DatasetContentStatus'                     => [
			'type'    => 'structure',
			'members' => [
				'state'  => [ 'shape' => 'DatasetContentState', ],
				'reason' => [ 'shape' => 'Reason', ],
			],
		],
		'DatasetContentSummaries'                  => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DatasetContentSummary', ],
		],
		'DatasetContentSummary'                    => [
			'type'    => 'structure',
			'members' => [
				'version'      => [ 'shape' => 'DatasetContentVersion', ],
				'status'       => [ 'shape' => 'DatasetContentStatus', ],
				'creationTime' => [ 'shape' => 'Timestamp', ],
				'scheduleTime' => [ 'shape' => 'Timestamp', ],
			],
		],
		'DatasetContentVersion'                    => [ 'type' => 'string', 'max' => 36, 'min' => 7, ],
		'DatasetContentVersionValue'               => [
			'type'     => 'structure',
			'required' => [ 'datasetName', ],
			'members'  => [ 'datasetName' => [ 'shape' => 'DatasetName', ], ],
		],
		'DatasetEntries'                           => [ 'type' => 'list', 'member' => [ 'shape' => 'DatasetEntry', ], ],
		'DatasetEntry'                             => [
			'type'    => 'structure',
			'members' => [
				'entryName' => [ 'shape' => 'EntryName', ],
				'dataURI'   => [ 'shape' => 'PresignedURI', ],
			],
		],
		'DatasetName'                              => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_]+$',
		],
		'DatasetStatus'                            => [
			'type' => 'string',
			'enum' => [ 'CREATING', 'ACTIVE', 'DELETING', ],
		],
		'DatasetSummaries'                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DatasetSummary', ],
		],
		'DatasetSummary'                           => [
			'type'    => 'structure',
			'members' => [
				'datasetName'    => [ 'shape' => 'DatasetName', ],
				'status'         => [ 'shape' => 'DatasetStatus', ],
				'creationTime'   => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime' => [ 'shape' => 'Timestamp', ],
				'triggers'       => [ 'shape' => 'DatasetTriggers', ],
				'actions'        => [ 'shape' => 'DatasetActionSummaries', ],
			],
		],
		'DatasetTrigger'                           => [
			'type'    => 'structure',
			'members' => [
				'schedule' => [ 'shape' => 'Schedule', ],
				'dataset'  => [ 'shape' => 'TriggeringDataset', ],
			],
		],
		'DatasetTriggers'                          => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DatasetTrigger', ],
			'max'    => 5,
			'min'    => 0,
		],
		'Datastore'                                => [
			'type'    => 'structure',
			'members' => [
				'name'            => [ 'shape' => 'DatastoreName', ],
				'storage'         => [ 'shape' => 'DatastoreStorage', ],
				'arn'             => [ 'shape' => 'DatastoreArn', ],
				'status'          => [ 'shape' => 'DatastoreStatus', ],
				'retentionPeriod' => [ 'shape' => 'RetentionPeriod', ],
				'creationTime'    => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime'  => [ 'shape' => 'Timestamp', ],
			],
		],
		'DatastoreActivity'                        => [
			'type'     => 'structure',
			'required' => [ 'name', 'datastoreName', ],
			'members'  => [
				'name'          => [ 'shape' => 'ActivityName', ],
				'datastoreName' => [ 'shape' => 'DatastoreName', ],
			],
		],
		'DatastoreArn'                             => [ 'type' => 'string', ],
		'DatastoreName'                            => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_]+$',
		],
		'DatastoreStatistics'                      => [
			'type'    => 'structure',
			'members' => [ 'size' => [ 'shape' => 'EstimatedResourceSize', ], ],
		],
		'DatastoreStatus'                          => [
			'type' => 'string',
			'enum' => [ 'CREATING', 'ACTIVE', 'DELETING', ],
		],
		'DatastoreStorage'                         => [
			'type'    => 'structure',
			'members' => [
				'serviceManagedS3'  => [ 'shape' => 'ServiceManagedDatastoreS3Storage', ],
				'customerManagedS3' => [ 'shape' => 'CustomerManagedDatastoreS3Storage', ],
			],
		],
		'DatastoreStorageSummary'                  => [
			'type'    => 'structure',
			'members' => [
				'serviceManagedS3'  => [ 'shape' => 'ServiceManagedDatastoreS3StorageSummary', ],
				'customerManagedS3' => [ 'shape' => 'CustomerManagedDatastoreS3StorageSummary', ],
			],
		],
		'DatastoreSummaries'                       => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DatastoreSummary', ],
		],
		'DatastoreSummary'                         => [
			'type'    => 'structure',
			'members' => [
				'datastoreName'    => [ 'shape' => 'DatastoreName', ],
				'datastoreStorage' => [ 'shape' => 'DatastoreStorageSummary', ],
				'status'           => [ 'shape' => 'DatastoreStatus', ],
				'creationTime'     => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime'   => [ 'shape' => 'Timestamp', ],
			],
		],
		'DeleteChannelRequest'                     => [
			'type'     => 'structure',
			'required' => [ 'channelName', ],
			'members'  => [
				'channelName' => [
					'shape'        => 'ChannelName',
					'location'     => 'uri',
					'locationName' => 'channelName',
				],
			],
		],
		'DeleteDatasetContentRequest'              => [
			'type'     => 'structure',
			'required' => [ 'datasetName', ],
			'members'  => [
				'datasetName' => [
					'shape'        => 'DatasetName',
					'location'     => 'uri',
					'locationName' => 'datasetName',
				],
				'versionId'   => [
					'shape'        => 'DatasetContentVersion',
					'location'     => 'querystring',
					'locationName' => 'versionId',
				],
			],
		],
		'DeleteDatasetRequest'                     => [
			'type'     => 'structure',
			'required' => [ 'datasetName', ],
			'members'  => [
				'datasetName' => [
					'shape'        => 'DatasetName',
					'location'     => 'uri',
					'locationName' => 'datasetName',
				],
			],
		],
		'DeleteDatastoreRequest'                   => [
			'type'     => 'structure',
			'required' => [ 'datastoreName', ],
			'members'  => [
				'datastoreName' => [
					'shape'        => 'DatastoreName',
					'location'     => 'uri',
					'locationName' => 'datastoreName',
				],
			],
		],
		'DeletePipelineRequest'                    => [
			'type'     => 'structure',
			'required' => [ 'pipelineName', ],
			'members'  => [
				'pipelineName' => [
					'shape'        => 'PipelineName',
					'location'     => 'uri',
					'locationName' => 'pipelineName',
				],
			],
		],
		'DeltaTime'                                => [
			'type'     => 'structure',
			'required' => [ 'offsetSeconds', 'timeExpression', ],
			'members'  => [
				'offsetSeconds'  => [ 'shape' => 'OffsetSeconds', ],
				'timeExpression' => [ 'shape' => 'TimeExpression', ],
			],
		],
		'DescribeChannelRequest'                   => [
			'type'     => 'structure',
			'required' => [ 'channelName', ],
			'members'  => [
				'channelName'       => [
					'shape'        => 'ChannelName',
					'location'     => 'uri',
					'locationName' => 'channelName',
				],
				'includeStatistics' => [
					'shape'        => 'IncludeStatisticsFlag',
					'location'     => 'querystring',
					'locationName' => 'includeStatistics',
				],
			],
		],
		'DescribeChannelResponse'                  => [
			'type'    => 'structure',
			'members' => [
				'channel'    => [ 'shape' => 'Channel', ],
				'statistics' => [ 'shape' => 'ChannelStatistics', ],
			],
		],
		'DescribeDatasetRequest'                   => [
			'type'     => 'structure',
			'required' => [ 'datasetName', ],
			'members'  => [
				'datasetName' => [
					'shape'        => 'DatasetName',
					'location'     => 'uri',
					'locationName' => 'datasetName',
				],
			],
		],
		'DescribeDatasetResponse'                  => [
			'type'    => 'structure',
			'members' => [ 'dataset' => [ 'shape' => 'Dataset', ], ],
		],
		'DescribeDatastoreRequest'                 => [
			'type'     => 'structure',
			'required' => [ 'datastoreName', ],
			'members'  => [
				'datastoreName'     => [
					'shape'        => 'DatastoreName',
					'location'     => 'uri',
					'locationName' => 'datastoreName',
				],
				'includeStatistics' => [
					'shape'        => 'IncludeStatisticsFlag',
					'location'     => 'querystring',
					'locationName' => 'includeStatistics',
				],
			],
		],
		'DescribeDatastoreResponse'                => [
			'type'    => 'structure',
			'members' => [
				'datastore'  => [ 'shape' => 'Datastore', ],
				'statistics' => [ 'shape' => 'DatastoreStatistics', ],
			],
		],
		'DescribeLoggingOptionsRequest'            => [ 'type' => 'structure', 'members' => [], ],
		'DescribeLoggingOptionsResponse'           => [
			'type'    => 'structure',
			'members' => [ 'loggingOptions' => [ 'shape' => 'LoggingOptions', ], ],
		],
		'DescribePipelineRequest'                  => [
			'type'     => 'structure',
			'required' => [ 'pipelineName', ],
			'members'  => [
				'pipelineName' => [
					'shape'        => 'PipelineName',
					'location'     => 'uri',
					'locationName' => 'pipelineName',
				],
			],
		],
		'DescribePipelineResponse'                 => [
			'type'    => 'structure',
			'members' => [ 'pipeline' => [ 'shape' => 'Pipeline', ], ],
		],
		'DeviceRegistryEnrichActivity'             => [
			'type'     => 'structure',
			'required' => [ 'name', 'attribute', 'thingName', 'roleArn', ],
			'members'  => [
				'name'      => [ 'shape' => 'ActivityName', ],
				'attribute' => [ 'shape' => 'AttributeName', ],
				'thingName' => [ 'shape' => 'AttributeName', ],
				'roleArn'   => [ 'shape' => 'RoleArn', ],
				'next'      => [ 'shape' => 'ActivityName', ],
			],
		],
		'DeviceShadowEnrichActivity'               => [
			'type'     => 'structure',
			'required' => [ 'name', 'attribute', 'thingName', 'roleArn', ],
			'members'  => [
				'name'      => [ 'shape' => 'ActivityName', ],
				'attribute' => [ 'shape' => 'AttributeName', ],
				'thingName' => [ 'shape' => 'AttributeName', ],
				'roleArn'   => [ 'shape' => 'RoleArn', ],
				'next'      => [ 'shape' => 'ActivityName', ],
			],
		],
		'DoubleValue'                              => [ 'type' => 'double', ],
		'EndTime'                                  => [ 'type' => 'timestamp', ],
		'EntryName'                                => [ 'type' => 'string', ],
		'ErrorCode'                                => [ 'type' => 'string', ],
		'ErrorMessage'                             => [ 'type' => 'string', ],
		'EstimatedResourceSize'                    => [
			'type'    => 'structure',
			'members' => [
				'estimatedSizeInBytes' => [ 'shape' => 'SizeInBytes', ],
				'estimatedOn'          => [ 'shape' => 'Timestamp', ],
			],
		],
		'FilterActivity'                           => [
			'type'     => 'structure',
			'required' => [ 'name', 'filter', ],
			'members'  => [
				'name'   => [ 'shape' => 'ActivityName', ],
				'filter' => [ 'shape' => 'FilterExpression', ],
				'next'   => [ 'shape' => 'ActivityName', ],
			],
		],
		'FilterExpression'                         => [ 'type' => 'string', 'max' => 256, 'min' => 1, ],
		'GetDatasetContentRequest'                 => [
			'type'     => 'structure',
			'required' => [ 'datasetName', ],
			'members'  => [
				'datasetName' => [
					'shape'        => 'DatasetName',
					'location'     => 'uri',
					'locationName' => 'datasetName',
				],
				'versionId'   => [
					'shape'        => 'DatasetContentVersion',
					'location'     => 'querystring',
					'locationName' => 'versionId',
				],
			],
		],
		'GetDatasetContentResponse'                => [
			'type'    => 'structure',
			'members' => [
				'entries'   => [ 'shape' => 'DatasetEntries', ],
				'timestamp' => [ 'shape' => 'Timestamp', ],
				'status'    => [ 'shape' => 'DatasetContentStatus', ],
			],
		],
		'GlueConfiguration'                        => [
			'type'     => 'structure',
			'required' => [ 'tableName', 'databaseName', ],
			'members'  => [
				'tableName'    => [ 'shape' => 'GlueTableName', ],
				'databaseName' => [ 'shape' => 'GlueDatabaseName', ],
			],
		],
		'GlueDatabaseName'                         => [
			'type'    => 'string',
			'max'     => 150,
			'min'     => 1,
			'pattern' => '[\\u0020-\\uD7FF\\uE000-\\uFFFD\\uD800\\uDC00-\\uDBFF\\uDFFF\\t]*',
		],
		'GlueTableName'                            => [
			'type'    => 'string',
			'max'     => 150,
			'min'     => 1,
			'pattern' => '[\\u0020-\\uD7FF\\uE000-\\uFFFD\\uD800\\uDC00-\\uDBFF\\uDFFF\\t]*',
		],
		'Image'                                    => [ 'type' => 'string', 'max' => 255, ],
		'IncludeStatisticsFlag'                    => [ 'type' => 'boolean', ],
		'InternalFailureException'                 => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'errorMessage', ], ],
			'error'     => [ 'httpStatusCode' => 500, ],
			'exception' => true,
			'fault'     => true,
		],
		'InvalidRequestException'                  => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'errorMessage', ], ],
			'error'     => [ 'httpStatusCode' => 400, ],
			'exception' => true,
		],
		'IotEventsDestinationConfiguration'        => [
			'type'     => 'structure',
			'required' => [ 'inputName', 'roleArn', ],
			'members'  => [
				'inputName' => [ 'shape' => 'IotEventsInputName', ],
				'roleArn'   => [ 'shape' => 'RoleArn', ],
			],
		],
		'IotEventsInputName'                       => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^[a-zA-Z][a-zA-Z0-9_]*$',
		],
		'LambdaActivity'                           => [
			'type'     => 'structure',
			'required' => [ 'name', 'lambdaName', 'batchSize', ],
			'members'  => [
				'name'       => [ 'shape' => 'ActivityName', ],
				'lambdaName' => [ 'shape' => 'LambdaName', ],
				'batchSize'  => [ 'shape' => 'ActivityBatchSize', ],
				'next'       => [ 'shape' => 'ActivityName', ],
			],
		],
		'LambdaName'                               => [
			'type'    => 'string',
			'max'     => 64,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_-]+$',
		],
		'LimitExceededException'                   => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'errorMessage', ], ],
			'error'     => [ 'httpStatusCode' => 410, ],
			'exception' => true,
		],
		'ListChannelsRequest'                      => [
			'type'    => 'structure',
			'members' => [
				'nextToken'  => [
					'shape'        => 'NextToken',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
				'maxResults' => [
					'shape'        => 'MaxResults',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
			],
		],
		'ListChannelsResponse'                     => [
			'type'    => 'structure',
			'members' => [
				'channelSummaries' => [ 'shape' => 'ChannelSummaries', ],
				'nextToken'        => [ 'shape' => 'NextToken', ],
			],
		],
		'ListDatasetContentsRequest'               => [
			'type'     => 'structure',
			'required' => [ 'datasetName', ],
			'members'  => [
				'datasetName'        => [
					'shape'        => 'DatasetName',
					'location'     => 'uri',
					'locationName' => 'datasetName',
				],
				'nextToken'          => [
					'shape'        => 'NextToken',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
				'maxResults'         => [
					'shape'        => 'MaxResults',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
				'scheduledOnOrAfter' => [
					'shape'        => 'Timestamp',
					'location'     => 'querystring',
					'locationName' => 'scheduledOnOrAfter',
				],
				'scheduledBefore'    => [
					'shape'        => 'Timestamp',
					'location'     => 'querystring',
					'locationName' => 'scheduledBefore',
				],
			],
		],
		'ListDatasetContentsResponse'              => [
			'type'    => 'structure',
			'members' => [
				'datasetContentSummaries' => [ 'shape' => 'DatasetContentSummaries', ],
				'nextToken'               => [ 'shape' => 'NextToken', ],
			],
		],
		'ListDatasetsRequest'                      => [
			'type'    => 'structure',
			'members' => [
				'nextToken'  => [
					'shape'        => 'NextToken',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
				'maxResults' => [
					'shape'        => 'MaxResults',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
			],
		],
		'ListDatasetsResponse'                     => [
			'type'    => 'structure',
			'members' => [
				'datasetSummaries' => [ 'shape' => 'DatasetSummaries', ],
				'nextToken'        => [ 'shape' => 'NextToken', ],
			],
		],
		'ListDatastoresRequest'                    => [
			'type'    => 'structure',
			'members' => [
				'nextToken'  => [
					'shape'        => 'NextToken',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
				'maxResults' => [
					'shape'        => 'MaxResults',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
			],
		],
		'ListDatastoresResponse'                   => [
			'type'    => 'structure',
			'members' => [
				'datastoreSummaries' => [ 'shape' => 'DatastoreSummaries', ],
				'nextToken'          => [ 'shape' => 'NextToken', ],
			],
		],
		'ListPipelinesRequest'                     => [
			'type'    => 'structure',
			'members' => [
				'nextToken'  => [
					'shape'        => 'NextToken',
					'location'     => 'querystring',
					'locationName' => 'nextToken',
				],
				'maxResults' => [
					'shape'        => 'MaxResults',
					'location'     => 'querystring',
					'locationName' => 'maxResults',
				],
			],
		],
		'ListPipelinesResponse'                    => [
			'type'    => 'structure',
			'members' => [
				'pipelineSummaries' => [ 'shape' => 'PipelineSummaries', ],
				'nextToken'         => [ 'shape' => 'NextToken', ],
			],
		],
		'ListTagsForResourceRequest'               => [
			'type'     => 'structure',
			'required' => [ 'resourceArn', ],
			'members'  => [
				'resourceArn' => [
					'shape'        => 'ResourceArn',
					'location'     => 'querystring',
					'locationName' => 'resourceArn',
				],
			],
		],
		'ListTagsForResourceResponse'              => [
			'type'    => 'structure',
			'members' => [ 'tags' => [ 'shape' => 'TagList', ], ],
		],
		'LogResult'                                => [ 'type' => 'string', ],
		'LoggingEnabled'                           => [ 'type' => 'boolean', ],
		'LoggingLevel'                             => [ 'type' => 'string', 'enum' => [ 'ERROR', ], ],
		'LoggingOptions'                           => [
			'type'     => 'structure',
			'required' => [ 'roleArn', 'level', 'enabled', ],
			'members'  => [
				'roleArn' => [ 'shape' => 'RoleArn', ],
				'level'   => [ 'shape' => 'LoggingLevel', ],
				'enabled' => [ 'shape' => 'LoggingEnabled', ],
			],
		],
		'MathActivity'                             => [
			'type'     => 'structure',
			'required' => [ 'name', 'attribute', 'math', ],
			'members'  => [
				'name'      => [ 'shape' => 'ActivityName', ],
				'attribute' => [ 'shape' => 'AttributeName', ],
				'math'      => [ 'shape' => 'MathExpression', ],
				'next'      => [ 'shape' => 'ActivityName', ],
			],
		],
		'MathExpression'                           => [ 'type' => 'string', 'max' => 256, 'min' => 1, ],
		'MaxMessages'                              => [ 'type' => 'integer', 'max' => 10, 'min' => 1, ],
		'MaxResults'                               => [ 'type' => 'integer', 'max' => 250, 'min' => 1, ],
		'MaxVersions'                              => [ 'type' => 'integer', 'max' => 1000, 'min' => 1, ],
		'Message'                                  => [
			'type'     => 'structure',
			'required' => [ 'messageId', 'payload', ],
			'members'  => [
				'messageId' => [ 'shape' => 'MessageId', ],
				'payload'   => [ 'shape' => 'MessagePayload', ],
			],
		],
		'MessageId'                                => [ 'type' => 'string', 'max' => 128, 'min' => 1, ],
		'MessagePayload'                           => [ 'type' => 'blob', ],
		'MessagePayloads'                          => [
			'type'   => 'list',
			'member' => [ 'shape' => 'MessagePayload', ],
			'max'    => 10,
			'min'    => 1,
		],
		'Messages'                                 => [ 'type' => 'list', 'member' => [ 'shape' => 'Message', ], ],
		'NextToken'                                => [ 'type' => 'string', ],
		'OffsetSeconds'                            => [ 'type' => 'integer', ],
		'OutputFileName'                           => [ 'type' => 'string', 'pattern' => '[\\w\\.-]{1,255}', ],
		'OutputFileUriValue'                       => [
			'type'     => 'structure',
			'required' => [ 'fileName', ],
			'members'  => [ 'fileName' => [ 'shape' => 'OutputFileName', ], ],
		],
		'Pipeline'                                 => [
			'type'    => 'structure',
			'members' => [
				'name'                  => [ 'shape' => 'PipelineName', ],
				'arn'                   => [ 'shape' => 'PipelineArn', ],
				'activities'            => [ 'shape' => 'PipelineActivities', ],
				'reprocessingSummaries' => [ 'shape' => 'ReprocessingSummaries', ],
				'creationTime'          => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime'        => [ 'shape' => 'Timestamp', ],
			],
		],
		'PipelineActivities'                       => [
			'type'   => 'list',
			'member' => [ 'shape' => 'PipelineActivity', ],
			'max'    => 25,
			'min'    => 1,
		],
		'PipelineActivity'                         => [
			'type'    => 'structure',
			'members' => [
				'channel'              => [ 'shape' => 'ChannelActivity', ],
				'lambda'               => [ 'shape' => 'LambdaActivity', ],
				'datastore'            => [ 'shape' => 'DatastoreActivity', ],
				'addAttributes'        => [ 'shape' => 'AddAttributesActivity', ],
				'removeAttributes'     => [ 'shape' => 'RemoveAttributesActivity', ],
				'selectAttributes'     => [ 'shape' => 'SelectAttributesActivity', ],
				'filter'               => [ 'shape' => 'FilterActivity', ],
				'math'                 => [ 'shape' => 'MathActivity', ],
				'deviceRegistryEnrich' => [ 'shape' => 'DeviceRegistryEnrichActivity', ],
				'deviceShadowEnrich'   => [ 'shape' => 'DeviceShadowEnrichActivity', ],
			],
		],
		'PipelineArn'                              => [ 'type' => 'string', ],
		'PipelineName'                             => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_]+$',
		],
		'PipelineSummaries'                        => [
			'type'   => 'list',
			'member' => [ 'shape' => 'PipelineSummary', ],
		],
		'PipelineSummary'                          => [
			'type'    => 'structure',
			'members' => [
				'pipelineName'          => [ 'shape' => 'PipelineName', ],
				'reprocessingSummaries' => [ 'shape' => 'ReprocessingSummaries', ],
				'creationTime'          => [ 'shape' => 'Timestamp', ],
				'lastUpdateTime'        => [ 'shape' => 'Timestamp', ],
			],
		],
		'PresignedURI'                             => [ 'type' => 'string', ],
		'PutLoggingOptionsRequest'                 => [
			'type'     => 'structure',
			'required' => [ 'loggingOptions', ],
			'members'  => [ 'loggingOptions' => [ 'shape' => 'LoggingOptions', ], ],
		],
		'QueryFilter'                              => [
			'type'    => 'structure',
			'members' => [ 'deltaTime' => [ 'shape' => 'DeltaTime', ], ],
		],
		'QueryFilters'                             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'QueryFilter', ],
			'max'    => 1,
			'min'    => 0,
		],
		'Reason'                                   => [ 'type' => 'string', ],
		'RemoveAttributesActivity'                 => [
			'type'     => 'structure',
			'required' => [ 'name', 'attributes', ],
			'members'  => [
				'name'       => [ 'shape' => 'ActivityName', ],
				'attributes' => [ 'shape' => 'AttributeNames', ],
				'next'       => [ 'shape' => 'ActivityName', ],
			],
		],
		'ReprocessingId'                           => [ 'type' => 'string', ],
		'ReprocessingStatus'                       => [
			'type' => 'string',
			'enum' => [ 'RUNNING', 'SUCCEEDED', 'CANCELLED', 'FAILED', ],
		],
		'ReprocessingSummaries'                    => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ReprocessingSummary', ],
		],
		'ReprocessingSummary'                      => [
			'type'    => 'structure',
			'members' => [
				'id'           => [ 'shape' => 'ReprocessingId', ],
				'status'       => [ 'shape' => 'ReprocessingStatus', ],
				'creationTime' => [ 'shape' => 'Timestamp', ],
			],
		],
		'ResourceAlreadyExistsException'           => [
			'type'      => 'structure',
			'members'   => [
				'message'     => [ 'shape' => 'errorMessage', ],
				'resourceId'  => [ 'shape' => 'resourceId', ],
				'resourceArn' => [ 'shape' => 'resourceArn', ],
			],
			'error'     => [ 'httpStatusCode' => 409, ],
			'exception' => true,
		],
		'ResourceArn'                              => [ 'type' => 'string', 'max' => 2048, 'min' => 20, ],
		'ResourceConfiguration'                    => [
			'type'     => 'structure',
			'required' => [ 'computeType', 'volumeSizeInGB', ],
			'members'  => [
				'computeType'    => [ 'shape' => 'ComputeType', ],
				'volumeSizeInGB' => [ 'shape' => 'VolumeSizeInGB', ],
			],
		],
		'ResourceNotFoundException'                => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'errorMessage', ], ],
			'error'     => [ 'httpStatusCode' => 404, ],
			'exception' => true,
		],
		'RetentionPeriod'                          => [
			'type'    => 'structure',
			'members' => [
				'unlimited'    => [ 'shape' => 'UnlimitedRetentionPeriod', ],
				'numberOfDays' => [ 'shape' => 'RetentionPeriodInDays', ],
			],
		],
		'RetentionPeriodInDays'                    => [ 'type' => 'integer', 'min' => 1, ],
		'RoleArn'                                  => [ 'type' => 'string', 'max' => 2048, 'min' => 20, ],
		'RunPipelineActivityRequest'               => [
			'type'     => 'structure',
			'required' => [ 'pipelineActivity', 'payloads', ],
			'members'  => [
				'pipelineActivity' => [ 'shape' => 'PipelineActivity', ],
				'payloads'         => [ 'shape' => 'MessagePayloads', ],
			],
		],
		'RunPipelineActivityResponse'              => [
			'type'    => 'structure',
			'members' => [
				'payloads'  => [ 'shape' => 'MessagePayloads', ],
				'logResult' => [ 'shape' => 'LogResult', ],
			],
		],
		'S3DestinationConfiguration'               => [
			'type'     => 'structure',
			'required' => [ 'bucket', 'key', 'roleArn', ],
			'members'  => [
				'bucket'            => [ 'shape' => 'BucketName', ],
				'key'               => [ 'shape' => 'BucketKeyExpression', ],
				'glueConfiguration' => [ 'shape' => 'GlueConfiguration', ],
				'roleArn'           => [ 'shape' => 'RoleArn', ],
			],
		],
		'S3KeyPrefix'                              => [
			'type'    => 'string',
			'max'     => 255,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9!_.*\'()/{}:-]*/$',
		],
		'SampleChannelDataRequest'                 => [
			'type'     => 'structure',
			'required' => [ 'channelName', ],
			'members'  => [
				'channelName' => [
					'shape'        => 'ChannelName',
					'location'     => 'uri',
					'locationName' => 'channelName',
				],
				'maxMessages' => [
					'shape'        => 'MaxMessages',
					'location'     => 'querystring',
					'locationName' => 'maxMessages',
				],
				'startTime'   => [
					'shape'        => 'StartTime',
					'location'     => 'querystring',
					'locationName' => 'startTime',
				],
				'endTime'     => [
					'shape'        => 'EndTime',
					'location'     => 'querystring',
					'locationName' => 'endTime',
				],
			],
		],
		'SampleChannelDataResponse'                => [
			'type'    => 'structure',
			'members' => [ 'payloads' => [ 'shape' => 'MessagePayloads', ], ],
		],
		'Schedule'                                 => [
			'type'    => 'structure',
			'members' => [ 'expression' => [ 'shape' => 'ScheduleExpression', ], ],
		],
		'ScheduleExpression'                       => [ 'type' => 'string', ],
		'SelectAttributesActivity'                 => [
			'type'     => 'structure',
			'required' => [ 'name', 'attributes', ],
			'members'  => [
				'name'       => [ 'shape' => 'ActivityName', ],
				'attributes' => [ 'shape' => 'AttributeNames', ],
				'next'       => [ 'shape' => 'ActivityName', ],
			],
		],
		'ServiceManagedChannelS3Storage'           => [ 'type' => 'structure', 'members' => [], ],
		'ServiceManagedChannelS3StorageSummary'    => [ 'type' => 'structure', 'members' => [], ],
		'ServiceManagedDatastoreS3Storage'         => [ 'type' => 'structure', 'members' => [], ],
		'ServiceManagedDatastoreS3StorageSummary'  => [ 'type' => 'structure', 'members' => [], ],
		'ServiceUnavailableException'              => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'errorMessage', ], ],
			'error'     => [ 'httpStatusCode' => 503, ],
			'exception' => true,
			'fault'     => true,
		],
		'SizeInBytes'                              => [ 'type' => 'double', ],
		'SqlQuery'                                 => [ 'type' => 'string', ],
		'SqlQueryDatasetAction'                    => [
			'type'     => 'structure',
			'required' => [ 'sqlQuery', ],
			'members'  => [
				'sqlQuery' => [ 'shape' => 'SqlQuery', ],
				'filters'  => [ 'shape' => 'QueryFilters', ],
			],
		],
		'StartPipelineReprocessingRequest'         => [
			'type'     => 'structure',
			'required' => [ 'pipelineName', ],
			'members'  => [
				'pipelineName' => [
					'shape'        => 'PipelineName',
					'location'     => 'uri',
					'locationName' => 'pipelineName',
				],
				'startTime'    => [ 'shape' => 'StartTime', ],
				'endTime'      => [ 'shape' => 'EndTime', ],
			],
		],
		'StartPipelineReprocessingResponse'        => [
			'type'    => 'structure',
			'members' => [ 'reprocessingId' => [ 'shape' => 'ReprocessingId', ], ],
		],
		'StartTime'                                => [ 'type' => 'timestamp', ],
		'StringValue'                              => [ 'type' => 'string', 'max' => 1024, 'min' => 0, ],
		'Tag'                                      => [
			'type'     => 'structure',
			'required' => [ 'key', 'value', ],
			'members'  => [
				'key'   => [ 'shape' => 'TagKey', ],
				'value' => [ 'shape' => 'TagValue', ],
			],
		],
		'TagKey'                                   => [ 'type' => 'string', 'max' => 256, 'min' => 1, ],
		'TagKeyList'                               => [
			'type'   => 'list',
			'member' => [ 'shape' => 'TagKey', ],
			'max'    => 50,
			'min'    => 1,
		],
		'TagList'                                  => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Tag', ],
			'max'    => 50,
			'min'    => 1,
		],
		'TagResourceRequest'                       => [
			'type'     => 'structure',
			'required' => [ 'resourceArn', 'tags', ],
			'members'  => [
				'resourceArn' => [
					'shape'        => 'ResourceArn',
					'location'     => 'querystring',
					'locationName' => 'resourceArn',
				],
				'tags'        => [ 'shape' => 'TagList', ],
			],
		],
		'TagResourceResponse'                      => [ 'type' => 'structure', 'members' => [], ],
		'TagValue'                                 => [ 'type' => 'string', 'max' => 256, 'min' => 1, ],
		'ThrottlingException'                      => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'errorMessage', ], ],
			'error'     => [ 'httpStatusCode' => 429, ],
			'exception' => true,
		],
		'TimeExpression'                           => [ 'type' => 'string', ],
		'Timestamp'                                => [ 'type' => 'timestamp', ],
		'TriggeringDataset'                        => [
			'type'     => 'structure',
			'required' => [ 'name', ],
			'members'  => [ 'name' => [ 'shape' => 'DatasetName', ], ],
		],
		'UnlimitedRetentionPeriod'                 => [ 'type' => 'boolean', ],
		'UnlimitedVersioning'                      => [ 'type' => 'boolean', ],
		'UntagResourceRequest'                     => [
			'type'     => 'structure',
			'required' => [ 'resourceArn', 'tagKeys', ],
			'members'  => [
				'resourceArn' => [
					'shape'        => 'ResourceArn',
					'location'     => 'querystring',
					'locationName' => 'resourceArn',
				],
				'tagKeys'     => [
					'shape'        => 'TagKeyList',
					'location'     => 'querystring',
					'locationName' => 'tagKeys',
				],
			],
		],
		'UntagResourceResponse'                    => [ 'type' => 'structure', 'members' => [], ],
		'UpdateChannelRequest'                     => [
			'type'     => 'structure',
			'required' => [ 'channelName', ],
			'members'  => [
				'channelName'     => [
					'shape'        => 'ChannelName',
					'location'     => 'uri',
					'locationName' => 'channelName',
				],
				'channelStorage'  => [ 'shape' => 'ChannelStorage', ],
				'retentionPeriod' => [ 'shape' => 'RetentionPeriod', ],
			],
		],
		'UpdateDatasetRequest'                     => [
			'type'     => 'structure',
			'required' => [ 'datasetName', 'actions', ],
			'members'  => [
				'datasetName'             => [
					'shape'        => 'DatasetName',
					'location'     => 'uri',
					'locationName' => 'datasetName',
				],
				'actions'                 => [ 'shape' => 'DatasetActions', ],
				'triggers'                => [ 'shape' => 'DatasetTriggers', ],
				'contentDeliveryRules'    => [ 'shape' => 'DatasetContentDeliveryRules', ],
				'retentionPeriod'         => [ 'shape' => 'RetentionPeriod', ],
				'versioningConfiguration' => [ 'shape' => 'VersioningConfiguration', ],
			],
		],
		'UpdateDatastoreRequest'                   => [
			'type'     => 'structure',
			'required' => [ 'datastoreName', ],
			'members'  => [
				'datastoreName'    => [
					'shape'        => 'DatastoreName',
					'location'     => 'uri',
					'locationName' => 'datastoreName',
				],
				'retentionPeriod'  => [ 'shape' => 'RetentionPeriod', ],
				'datastoreStorage' => [ 'shape' => 'DatastoreStorage', ],
			],
		],
		'UpdatePipelineRequest'                    => [
			'type'     => 'structure',
			'required' => [ 'pipelineName', 'pipelineActivities', ],
			'members'  => [
				'pipelineName'       => [
					'shape'        => 'PipelineName',
					'location'     => 'uri',
					'locationName' => 'pipelineName',
				],
				'pipelineActivities' => [ 'shape' => 'PipelineActivities', ],
			],
		],
		'Variable'                                 => [
			'type'     => 'structure',
			'required' => [ 'name', ],
			'members'  => [
				'name'                       => [ 'shape' => 'VariableName', ],
				'stringValue'                => [ 'shape' => 'StringValue', ],
				'doubleValue'                => [
					'shape' => 'DoubleValue',
					'box'   => true,
				],
				'datasetContentVersionValue' => [ 'shape' => 'DatasetContentVersionValue', ],
				'outputFileUriValue'         => [ 'shape' => 'OutputFileUriValue', ],
			],
		],
		'VariableName'                             => [ 'type' => 'string', 'max' => 256, 'min' => 1, ],
		'Variables'                                => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Variable', ],
			'max'    => 50,
			'min'    => 0,
		],
		'VersioningConfiguration'                  => [
			'type'    => 'structure',
			'members' => [
				'unlimited'   => [ 'shape' => 'UnlimitedVersioning', ],
				'maxVersions' => [ 'shape' => 'MaxVersions', ],
			],
		],
		'VolumeSizeInGB'                           => [ 'type' => 'integer', 'max' => 50, 'min' => 1, ],
		'errorMessage'                             => [ 'type' => 'string', ],
		'resourceArn'                              => [ 'type' => 'string', ],
		'resourceId'                               => [ 'type' => 'string', ],
	],
];
