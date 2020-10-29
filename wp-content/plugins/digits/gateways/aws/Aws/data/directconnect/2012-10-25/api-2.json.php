<?php
// This file was auto-generated from sdk-root/src/data/directconnect/2012-10-25/api-2.json
return [
	'version'    => '2.0',
	'metadata'   => [
		'apiVersion'       => '2012-10-25',
		'endpointPrefix'   => 'directconnect',
		'jsonVersion'      => '1.1',
		'protocol'         => 'json',
		'serviceFullName'  => 'AWS Direct Connect',
		'serviceId'        => 'Direct Connect',
		'signatureVersion' => 'v4',
		'targetPrefix'     => 'OvertureService',
		'uid'              => 'directconnect-2012-10-25',
	],
	'operations' => [
		'AcceptDirectConnectGatewayAssociationProposal'    => [
			'name'   => 'AcceptDirectConnectGatewayAssociationProposal',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AcceptDirectConnectGatewayAssociationProposalRequest', ],
			'output' => [ 'shape' => 'AcceptDirectConnectGatewayAssociationProposalResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'AllocateConnectionOnInterconnect'                 => [
			'name'       => 'AllocateConnectionOnInterconnect',
			'http'       => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'      => [ 'shape' => 'AllocateConnectionOnInterconnectRequest', ],
			'output'     => [ 'shape' => 'Connection', ],
			'errors'     => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
			'deprecated' => true,
		],
		'AllocateHostedConnection'                         => [
			'name'   => 'AllocateHostedConnection',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AllocateHostedConnectionRequest', ],
			'output' => [ 'shape' => 'Connection', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'AllocatePrivateVirtualInterface'                  => [
			'name'   => 'AllocatePrivateVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AllocatePrivateVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'VirtualInterface', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'AllocatePublicVirtualInterface'                   => [
			'name'   => 'AllocatePublicVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AllocatePublicVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'VirtualInterface', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'AllocateTransitVirtualInterface'                  => [
			'name'   => 'AllocateTransitVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AllocateTransitVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'AllocateTransitVirtualInterfaceResult', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'AssociateConnectionWithLag'                       => [
			'name'   => 'AssociateConnectionWithLag',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociateConnectionWithLagRequest', ],
			'output' => [ 'shape' => 'Connection', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'AssociateHostedConnection'                        => [
			'name'   => 'AssociateHostedConnection',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociateHostedConnectionRequest', ],
			'output' => [ 'shape' => 'Connection', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'AssociateVirtualInterface'                        => [
			'name'   => 'AssociateVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociateVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'VirtualInterface', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'ConfirmConnection'                                => [
			'name'   => 'ConfirmConnection',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'ConfirmConnectionRequest', ],
			'output' => [ 'shape' => 'ConfirmConnectionResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'ConfirmPrivateVirtualInterface'                   => [
			'name'   => 'ConfirmPrivateVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'ConfirmPrivateVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'ConfirmPrivateVirtualInterfaceResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'ConfirmPublicVirtualInterface'                    => [
			'name'   => 'ConfirmPublicVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'ConfirmPublicVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'ConfirmPublicVirtualInterfaceResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'ConfirmTransitVirtualInterface'                   => [
			'name'   => 'ConfirmTransitVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'ConfirmTransitVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'ConfirmTransitVirtualInterfaceResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateBGPPeer'                                    => [
			'name'   => 'CreateBGPPeer',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateBGPPeerRequest', ],
			'output' => [ 'shape' => 'CreateBGPPeerResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateConnection'                                 => [
			'name'   => 'CreateConnection',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateConnectionRequest', ],
			'output' => [ 'shape' => 'Connection', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateDirectConnectGateway'                       => [
			'name'   => 'CreateDirectConnectGateway',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateDirectConnectGatewayRequest', ],
			'output' => [ 'shape' => 'CreateDirectConnectGatewayResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateDirectConnectGatewayAssociation'            => [
			'name'   => 'CreateDirectConnectGatewayAssociation',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateDirectConnectGatewayAssociationRequest', ],
			'output' => [ 'shape' => 'CreateDirectConnectGatewayAssociationResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateDirectConnectGatewayAssociationProposal'    => [
			'name'   => 'CreateDirectConnectGatewayAssociationProposal',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateDirectConnectGatewayAssociationProposalRequest', ],
			'output' => [ 'shape' => 'CreateDirectConnectGatewayAssociationProposalResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateInterconnect'                               => [
			'name'   => 'CreateInterconnect',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateInterconnectRequest', ],
			'output' => [ 'shape' => 'Interconnect', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateLag'                                        => [
			'name'   => 'CreateLag',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateLagRequest', ],
			'output' => [ 'shape' => 'Lag', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreatePrivateVirtualInterface'                    => [
			'name'   => 'CreatePrivateVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreatePrivateVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'VirtualInterface', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreatePublicVirtualInterface'                     => [
			'name'   => 'CreatePublicVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreatePublicVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'VirtualInterface', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'CreateTransitVirtualInterface'                    => [
			'name'   => 'CreateTransitVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'CreateTransitVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'CreateTransitVirtualInterfaceResult', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteBGPPeer'                                    => [
			'name'   => 'DeleteBGPPeer',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteBGPPeerRequest', ],
			'output' => [ 'shape' => 'DeleteBGPPeerResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteConnection'                                 => [
			'name'   => 'DeleteConnection',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteConnectionRequest', ],
			'output' => [ 'shape' => 'Connection', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteDirectConnectGateway'                       => [
			'name'   => 'DeleteDirectConnectGateway',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteDirectConnectGatewayRequest', ],
			'output' => [ 'shape' => 'DeleteDirectConnectGatewayResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteDirectConnectGatewayAssociation'            => [
			'name'   => 'DeleteDirectConnectGatewayAssociation',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteDirectConnectGatewayAssociationRequest', ],
			'output' => [ 'shape' => 'DeleteDirectConnectGatewayAssociationResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteDirectConnectGatewayAssociationProposal'    => [
			'name'   => 'DeleteDirectConnectGatewayAssociationProposal',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteDirectConnectGatewayAssociationProposalRequest', ],
			'output' => [ 'shape' => 'DeleteDirectConnectGatewayAssociationProposalResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteInterconnect'                               => [
			'name'   => 'DeleteInterconnect',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteInterconnectRequest', ],
			'output' => [ 'shape' => 'DeleteInterconnectResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteLag'                                        => [
			'name'   => 'DeleteLag',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteLagRequest', ],
			'output' => [ 'shape' => 'Lag', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DeleteVirtualInterface'                           => [
			'name'   => 'DeleteVirtualInterface',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DeleteVirtualInterfaceRequest', ],
			'output' => [ 'shape' => 'DeleteVirtualInterfaceResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeConnectionLoa'                            => [
			'name'       => 'DescribeConnectionLoa',
			'http'       => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'      => [ 'shape' => 'DescribeConnectionLoaRequest', ],
			'output'     => [ 'shape' => 'DescribeConnectionLoaResponse', ],
			'errors'     => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
			'deprecated' => true,
		],
		'DescribeConnections'                              => [
			'name'   => 'DescribeConnections',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'DescribeConnectionsRequest', ],
			'output' => [ 'shape' => 'Connections', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeConnectionsOnInterconnect'                => [
			'name'       => 'DescribeConnectionsOnInterconnect',
			'http'       => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'      => [ 'shape' => 'DescribeConnectionsOnInterconnectRequest', ],
			'output'     => [ 'shape' => 'Connections', ],
			'errors'     => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
			'deprecated' => true,
		],
		'DescribeDirectConnectGatewayAssociationProposals' => [
			'name'   => 'DescribeDirectConnectGatewayAssociationProposals',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeDirectConnectGatewayAssociationProposalsRequest', ],
			'output' => [ 'shape' => 'DescribeDirectConnectGatewayAssociationProposalsResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeDirectConnectGatewayAssociations'         => [
			'name'   => 'DescribeDirectConnectGatewayAssociations',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeDirectConnectGatewayAssociationsRequest', ],
			'output' => [ 'shape' => 'DescribeDirectConnectGatewayAssociationsResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeDirectConnectGatewayAttachments'          => [
			'name'   => 'DescribeDirectConnectGatewayAttachments',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeDirectConnectGatewayAttachmentsRequest', ],
			'output' => [ 'shape' => 'DescribeDirectConnectGatewayAttachmentsResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeDirectConnectGateways'                    => [
			'name'   => 'DescribeDirectConnectGateways',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeDirectConnectGatewaysRequest', ],
			'output' => [ 'shape' => 'DescribeDirectConnectGatewaysResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeHostedConnections'                        => [
			'name'   => 'DescribeHostedConnections',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeHostedConnectionsRequest', ],
			'output' => [ 'shape' => 'Connections', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeInterconnectLoa'                          => [
			'name'       => 'DescribeInterconnectLoa',
			'http'       => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'      => [ 'shape' => 'DescribeInterconnectLoaRequest', ],
			'output'     => [ 'shape' => 'DescribeInterconnectLoaResponse', ],
			'errors'     => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
			'deprecated' => true,
		],
		'DescribeInterconnects'                            => [
			'name'   => 'DescribeInterconnects',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeInterconnectsRequest', ],
			'output' => [ 'shape' => 'Interconnects', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeLags'                                     => [
			'name'   => 'DescribeLags',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeLagsRequest', ],
			'output' => [ 'shape' => 'Lags', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeLoa'                                      => [
			'name'   => 'DescribeLoa',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeLoaRequest', ],
			'output' => [ 'shape' => 'Loa', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeLocations'                                => [
			'name'   => 'DescribeLocations',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'output' => [ 'shape' => 'Locations', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeTags'                                     => [
			'name'   => 'DescribeTags',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeTagsRequest', ],
			'output' => [ 'shape' => 'DescribeTagsResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeVirtualGateways'                          => [
			'name'   => 'DescribeVirtualGateways',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'output' => [ 'shape' => 'VirtualGateways', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DescribeVirtualInterfaces'                        => [
			'name'   => 'DescribeVirtualInterfaces',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeVirtualInterfacesRequest', ],
			'output' => [ 'shape' => 'VirtualInterfaces', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'DisassociateConnectionFromLag'                    => [
			'name'   => 'DisassociateConnectionFromLag',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DisassociateConnectionFromLagRequest', ],
			'output' => [ 'shape' => 'Connection', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'TagResource'                                      => [
			'name'   => 'TagResource',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'TagResourceRequest', ],
			'output' => [ 'shape' => 'TagResourceResponse', ],
			'errors' => [
				[ 'shape' => 'DuplicateTagKeysException', ],
				[ 'shape' => 'TooManyTagsException', ],
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'UntagResource'                                    => [
			'name'   => 'UntagResource',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UntagResourceRequest', ],
			'output' => [ 'shape' => 'UntagResourceResponse', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'UpdateDirectConnectGatewayAssociation'            => [
			'name'   => 'UpdateDirectConnectGatewayAssociation',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateDirectConnectGatewayAssociationRequest', ],
			'output' => [ 'shape' => 'UpdateDirectConnectGatewayAssociationResult', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'UpdateLag'                                        => [
			'name'   => 'UpdateLag',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateLagRequest', ],
			'output' => [ 'shape' => 'Lag', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
		'UpdateVirtualInterfaceAttributes'                 => [
			'name'   => 'UpdateVirtualInterfaceAttributes',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateVirtualInterfaceAttributesRequest', ],
			'output' => [ 'shape' => 'VirtualInterface', ],
			'errors' => [
				[ 'shape' => 'DirectConnectServerException', ],
				[ 'shape' => 'DirectConnectClientException', ],
			],
		],
	],
	'shapes'     => [
		'ASN'                                                     => [ 'type' => 'integer', ],
		'AcceptDirectConnectGatewayAssociationProposalRequest'    => [
			'type'     => 'structure',
			'required' => [
				'directConnectGatewayId',
				'proposalId',
				'associatedGatewayOwnerAccount',
			],
			'members'  => [
				'directConnectGatewayId'                        => [ 'shape' => 'DirectConnectGatewayId', ],
				'proposalId'                                    => [ 'shape' => 'DirectConnectGatewayAssociationProposalId', ],
				'associatedGatewayOwnerAccount'                 => [ 'shape' => 'OwnerAccount', ],
				'overrideAllowedPrefixesToDirectConnectGateway' => [ 'shape' => 'RouteFilterPrefixList', ],
			],
		],
		'AcceptDirectConnectGatewayAssociationProposalResult'     => [
			'type'    => 'structure',
			'members' => [ 'directConnectGatewayAssociation' => [ 'shape' => 'DirectConnectGatewayAssociation', ], ],
		],
		'AddressFamily'                                           => [
			'type' => 'string',
			'enum' => [ 'ipv4', 'ipv6', ],
		],
		'AllocateConnectionOnInterconnectRequest'                 => [
			'type'     => 'structure',
			'required' => [
				'bandwidth',
				'connectionName',
				'ownerAccount',
				'interconnectId',
				'vlan',
			],
			'members'  => [
				'bandwidth'      => [ 'shape' => 'Bandwidth', ],
				'connectionName' => [ 'shape' => 'ConnectionName', ],
				'ownerAccount'   => [ 'shape' => 'OwnerAccount', ],
				'interconnectId' => [ 'shape' => 'InterconnectId', ],
				'vlan'           => [ 'shape' => 'VLAN', ],
			],
		],
		'AllocateHostedConnectionRequest'                         => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'ownerAccount',
				'bandwidth',
				'connectionName',
				'vlan',
			],
			'members'  => [
				'connectionId'   => [ 'shape' => 'ConnectionId', ],
				'ownerAccount'   => [ 'shape' => 'OwnerAccount', ],
				'bandwidth'      => [ 'shape' => 'Bandwidth', ],
				'connectionName' => [ 'shape' => 'ConnectionName', ],
				'vlan'           => [ 'shape' => 'VLAN', ],
				'tags'           => [ 'shape' => 'TagList', ],
			],
		],
		'AllocatePrivateVirtualInterfaceRequest'                  => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'ownerAccount',
				'newPrivateVirtualInterfaceAllocation',
			],
			'members'  => [
				'connectionId'                         => [ 'shape' => 'ConnectionId', ],
				'ownerAccount'                         => [ 'shape' => 'OwnerAccount', ],
				'newPrivateVirtualInterfaceAllocation' => [ 'shape' => 'NewPrivateVirtualInterfaceAllocation', ],
			],
		],
		'AllocatePublicVirtualInterfaceRequest'                   => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'ownerAccount',
				'newPublicVirtualInterfaceAllocation',
			],
			'members'  => [
				'connectionId'                        => [ 'shape' => 'ConnectionId', ],
				'ownerAccount'                        => [ 'shape' => 'OwnerAccount', ],
				'newPublicVirtualInterfaceAllocation' => [ 'shape' => 'NewPublicVirtualInterfaceAllocation', ],
			],
		],
		'AllocateTransitVirtualInterfaceRequest'                  => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'ownerAccount',
				'newTransitVirtualInterfaceAllocation',
			],
			'members'  => [
				'connectionId'                         => [ 'shape' => 'ConnectionId', ],
				'ownerAccount'                         => [ 'shape' => 'OwnerAccount', ],
				'newTransitVirtualInterfaceAllocation' => [ 'shape' => 'NewTransitVirtualInterfaceAllocation', ],
			],
		],
		'AllocateTransitVirtualInterfaceResult'                   => [
			'type'    => 'structure',
			'members' => [ 'virtualInterface' => [ 'shape' => 'VirtualInterface', ], ],
		],
		'AmazonAddress'                                           => [ 'type' => 'string', ],
		'AssociateConnectionWithLagRequest'                       => [
			'type'     => 'structure',
			'required' => [ 'connectionId', 'lagId', ],
			'members'  => [
				'connectionId' => [ 'shape' => 'ConnectionId', ],
				'lagId'        => [ 'shape' => 'LagId', ],
			],
		],
		'AssociateHostedConnectionRequest'                        => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'parentConnectionId',
			],
			'members'  => [
				'connectionId'       => [ 'shape' => 'ConnectionId', ],
				'parentConnectionId' => [ 'shape' => 'ConnectionId', ],
			],
		],
		'AssociateVirtualInterfaceRequest'                        => [
			'type'     => 'structure',
			'required' => [
				'virtualInterfaceId',
				'connectionId',
			],
			'members'  => [
				'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ],
				'connectionId'       => [ 'shape' => 'ConnectionId', ],
			],
		],
		'AssociatedGateway'                                       => [
			'type'    => 'structure',
			'members' => [
				'id'           => [ 'shape' => 'GatewayIdentifier', ],
				'type'         => [ 'shape' => 'GatewayType', ],
				'ownerAccount' => [ 'shape' => 'OwnerAccount', ],
				'region'       => [ 'shape' => 'Region', ],
			],
		],
		'AssociatedGatewayId'                                     => [ 'type' => 'string', ],
		'AvailablePortSpeeds'                                     => [
			'type'   => 'list',
			'member' => [ 'shape' => 'PortSpeed', ],
		],
		'AwsDevice'                                               => [ 'type' => 'string', 'deprecated' => true, ],
		'AwsDeviceV2'                                             => [ 'type' => 'string', ],
		'BGPAuthKey'                                              => [ 'type' => 'string', ],
		'BGPPeer'                                                 => [
			'type'    => 'structure',
			'members' => [
				'bgpPeerId'       => [ 'shape' => 'BGPPeerId', ],
				'asn'             => [ 'shape' => 'ASN', ],
				'authKey'         => [ 'shape' => 'BGPAuthKey', ],
				'addressFamily'   => [ 'shape' => 'AddressFamily', ],
				'amazonAddress'   => [ 'shape' => 'AmazonAddress', ],
				'customerAddress' => [ 'shape' => 'CustomerAddress', ],
				'bgpPeerState'    => [ 'shape' => 'BGPPeerState', ],
				'bgpStatus'       => [ 'shape' => 'BGPStatus', ],
				'awsDeviceV2'     => [ 'shape' => 'AwsDeviceV2', ],
			],
		],
		'BGPPeerId'                                               => [ 'type' => 'string', ],
		'BGPPeerList'                                             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'BGPPeer', ],
		],
		'BGPPeerState'                                            => [
			'type' => 'string',
			'enum' => [
				'verifying',
				'pending',
				'available',
				'deleting',
				'deleted',
			],
		],
		'BGPStatus'                                               => [
			'type' => 'string',
			'enum' => [ 'up', 'down', 'unknown', ],
		],
		'Bandwidth'                                               => [ 'type' => 'string', ],
		'BooleanFlag'                                             => [ 'type' => 'boolean', ],
		'CIDR'                                                    => [ 'type' => 'string', ],
		'ConfirmConnectionRequest'                                => [
			'type'     => 'structure',
			'required' => [ 'connectionId', ],
			'members'  => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ],
		],
		'ConfirmConnectionResponse'                               => [
			'type'    => 'structure',
			'members' => [ 'connectionState' => [ 'shape' => 'ConnectionState', ], ],
		],
		'ConfirmPrivateVirtualInterfaceRequest'                   => [
			'type'     => 'structure',
			'required' => [ 'virtualInterfaceId', ],
			'members'  => [
				'virtualInterfaceId'     => [ 'shape' => 'VirtualInterfaceId', ],
				'virtualGatewayId'       => [ 'shape' => 'VirtualGatewayId', ],
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
			],
		],
		'ConfirmPrivateVirtualInterfaceResponse'                  => [
			'type'    => 'structure',
			'members' => [ 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], ],
		],
		'ConfirmPublicVirtualInterfaceRequest'                    => [
			'type'     => 'structure',
			'required' => [ 'virtualInterfaceId', ],
			'members'  => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], ],
		],
		'ConfirmPublicVirtualInterfaceResponse'                   => [
			'type'    => 'structure',
			'members' => [ 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], ],
		],
		'ConfirmTransitVirtualInterfaceRequest'                   => [
			'type'     => 'structure',
			'required' => [
				'virtualInterfaceId',
				'directConnectGatewayId',
			],
			'members'  => [
				'virtualInterfaceId'     => [ 'shape' => 'VirtualInterfaceId', ],
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
			],
		],
		'ConfirmTransitVirtualInterfaceResponse'                  => [
			'type'    => 'structure',
			'members' => [ 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], ],
		],
		'Connection'                                              => [
			'type'    => 'structure',
			'members' => [
				'ownerAccount'         => [ 'shape' => 'OwnerAccount', ],
				'connectionId'         => [ 'shape' => 'ConnectionId', ],
				'connectionName'       => [ 'shape' => 'ConnectionName', ],
				'connectionState'      => [ 'shape' => 'ConnectionState', ],
				'region'               => [ 'shape' => 'Region', ],
				'location'             => [ 'shape' => 'LocationCode', ],
				'bandwidth'            => [ 'shape' => 'Bandwidth', ],
				'vlan'                 => [ 'shape' => 'VLAN', ],
				'partnerName'          => [ 'shape' => 'PartnerName', ],
				'loaIssueTime'         => [ 'shape' => 'LoaIssueTime', ],
				'lagId'                => [ 'shape' => 'LagId', ],
				'awsDevice'            => [ 'shape' => 'AwsDevice', ],
				'jumboFrameCapable'    => [ 'shape' => 'JumboFrameCapable', ],
				'awsDeviceV2'          => [ 'shape' => 'AwsDeviceV2', ],
				'hasLogicalRedundancy' => [ 'shape' => 'HasLogicalRedundancy', ],
				'tags'                 => [ 'shape' => 'TagList', ],
			],
		],
		'ConnectionId'                                            => [ 'type' => 'string', ],
		'ConnectionList'                                          => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Connection', ],
		],
		'ConnectionName'                                          => [ 'type' => 'string', ],
		'ConnectionState'                                         => [
			'type' => 'string',
			'enum' => [
				'ordering',
				'requested',
				'pending',
				'available',
				'down',
				'deleting',
				'deleted',
				'rejected',
				'unknown',
			],
		],
		'Connections'                                             => [
			'type'    => 'structure',
			'members' => [ 'connections' => [ 'shape' => 'ConnectionList', ], ],
		],
		'Count'                                                   => [ 'type' => 'integer', ],
		'CreateBGPPeerRequest'                                    => [
			'type'    => 'structure',
			'members' => [
				'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ],
				'newBGPPeer'         => [ 'shape' => 'NewBGPPeer', ],
			],
		],
		'CreateBGPPeerResponse'                                   => [
			'type'    => 'structure',
			'members' => [ 'virtualInterface' => [ 'shape' => 'VirtualInterface', ], ],
		],
		'CreateConnectionRequest'                                 => [
			'type'     => 'structure',
			'required' => [
				'location',
				'bandwidth',
				'connectionName',
			],
			'members'  => [
				'location'       => [ 'shape' => 'LocationCode', ],
				'bandwidth'      => [ 'shape' => 'Bandwidth', ],
				'connectionName' => [ 'shape' => 'ConnectionName', ],
				'lagId'          => [ 'shape' => 'LagId', ],
				'tags'           => [ 'shape' => 'TagList', ],
			],
		],
		'CreateDirectConnectGatewayAssociationProposalRequest'    => [
			'type'     => 'structure',
			'required' => [
				'directConnectGatewayId',
				'directConnectGatewayOwnerAccount',
				'gatewayId',
			],
			'members'  => [
				'directConnectGatewayId'                      => [ 'shape' => 'DirectConnectGatewayId', ],
				'directConnectGatewayOwnerAccount'            => [ 'shape' => 'OwnerAccount', ],
				'gatewayId'                                   => [ 'shape' => 'GatewayIdToAssociate', ],
				'addAllowedPrefixesToDirectConnectGateway'    => [ 'shape' => 'RouteFilterPrefixList', ],
				'removeAllowedPrefixesToDirectConnectGateway' => [ 'shape' => 'RouteFilterPrefixList', ],
			],
		],
		'CreateDirectConnectGatewayAssociationProposalResult'     => [
			'type'    => 'structure',
			'members' => [ 'directConnectGatewayAssociationProposal' => [ 'shape' => 'DirectConnectGatewayAssociationProposal', ], ],
		],
		'CreateDirectConnectGatewayAssociationRequest'            => [
			'type'     => 'structure',
			'required' => [ 'directConnectGatewayId', ],
			'members'  => [
				'directConnectGatewayId'                   => [ 'shape' => 'DirectConnectGatewayId', ],
				'gatewayId'                                => [ 'shape' => 'GatewayIdToAssociate', ],
				'addAllowedPrefixesToDirectConnectGateway' => [ 'shape' => 'RouteFilterPrefixList', ],
				'virtualGatewayId'                         => [ 'shape' => 'VirtualGatewayId', ],
			],
		],
		'CreateDirectConnectGatewayAssociationResult'             => [
			'type'    => 'structure',
			'members' => [ 'directConnectGatewayAssociation' => [ 'shape' => 'DirectConnectGatewayAssociation', ], ],
		],
		'CreateDirectConnectGatewayRequest'                       => [
			'type'     => 'structure',
			'required' => [ 'directConnectGatewayName', ],
			'members'  => [
				'directConnectGatewayName' => [ 'shape' => 'DirectConnectGatewayName', ],
				'amazonSideAsn'            => [ 'shape' => 'LongAsn', ],
			],
		],
		'CreateDirectConnectGatewayResult'                        => [
			'type'    => 'structure',
			'members' => [ 'directConnectGateway' => [ 'shape' => 'DirectConnectGateway', ], ],
		],
		'CreateInterconnectRequest'                               => [
			'type'     => 'structure',
			'required' => [
				'interconnectName',
				'bandwidth',
				'location',
			],
			'members'  => [
				'interconnectName' => [ 'shape' => 'InterconnectName', ],
				'bandwidth'        => [ 'shape' => 'Bandwidth', ],
				'location'         => [ 'shape' => 'LocationCode', ],
				'lagId'            => [ 'shape' => 'LagId', ],
				'tags'             => [ 'shape' => 'TagList', ],
			],
		],
		'CreateLagRequest'                                        => [
			'type'     => 'structure',
			'required' => [
				'numberOfConnections',
				'location',
				'connectionsBandwidth',
				'lagName',
			],
			'members'  => [
				'numberOfConnections'  => [ 'shape' => 'Count', ],
				'location'             => [ 'shape' => 'LocationCode', ],
				'connectionsBandwidth' => [ 'shape' => 'Bandwidth', ],
				'lagName'              => [ 'shape' => 'LagName', ],
				'connectionId'         => [ 'shape' => 'ConnectionId', ],
				'tags'                 => [ 'shape' => 'TagList', ],
				'childConnectionTags'  => [ 'shape' => 'TagList', ],
			],
		],
		'CreatePrivateVirtualInterfaceRequest'                    => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'newPrivateVirtualInterface',
			],
			'members'  => [
				'connectionId'               => [ 'shape' => 'ConnectionId', ],
				'newPrivateVirtualInterface' => [ 'shape' => 'NewPrivateVirtualInterface', ],
			],
		],
		'CreatePublicVirtualInterfaceRequest'                     => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'newPublicVirtualInterface',
			],
			'members'  => [
				'connectionId'              => [ 'shape' => 'ConnectionId', ],
				'newPublicVirtualInterface' => [ 'shape' => 'NewPublicVirtualInterface', ],
			],
		],
		'CreateTransitVirtualInterfaceRequest'                    => [
			'type'     => 'structure',
			'required' => [
				'connectionId',
				'newTransitVirtualInterface',
			],
			'members'  => [
				'connectionId'               => [ 'shape' => 'ConnectionId', ],
				'newTransitVirtualInterface' => [ 'shape' => 'NewTransitVirtualInterface', ],
			],
		],
		'CreateTransitVirtualInterfaceResult'                     => [
			'type'    => 'structure',
			'members' => [ 'virtualInterface' => [ 'shape' => 'VirtualInterface', ], ],
		],
		'CustomerAddress'                                         => [ 'type' => 'string', ],
		'DeleteBGPPeerRequest'                                    => [
			'type'    => 'structure',
			'members' => [
				'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ],
				'asn'                => [ 'shape' => 'ASN', ],
				'customerAddress'    => [ 'shape' => 'CustomerAddress', ],
				'bgpPeerId'          => [ 'shape' => 'BGPPeerId', ],
			],
		],
		'DeleteBGPPeerResponse'                                   => [
			'type'    => 'structure',
			'members' => [ 'virtualInterface' => [ 'shape' => 'VirtualInterface', ], ],
		],
		'DeleteConnectionRequest'                                 => [
			'type'     => 'structure',
			'required' => [ 'connectionId', ],
			'members'  => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ],
		],
		'DeleteDirectConnectGatewayAssociationProposalRequest'    => [
			'type'     => 'structure',
			'required' => [ 'proposalId', ],
			'members'  => [ 'proposalId' => [ 'shape' => 'DirectConnectGatewayAssociationProposalId', ], ],
		],
		'DeleteDirectConnectGatewayAssociationProposalResult'     => [
			'type'    => 'structure',
			'members' => [ 'directConnectGatewayAssociationProposal' => [ 'shape' => 'DirectConnectGatewayAssociationProposal', ], ],
		],
		'DeleteDirectConnectGatewayAssociationRequest'            => [
			'type'    => 'structure',
			'members' => [
				'associationId'          => [ 'shape' => 'DirectConnectGatewayAssociationId', ],
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'virtualGatewayId'       => [ 'shape' => 'VirtualGatewayId', ],
			],
		],
		'DeleteDirectConnectGatewayAssociationResult'             => [
			'type'    => 'structure',
			'members' => [ 'directConnectGatewayAssociation' => [ 'shape' => 'DirectConnectGatewayAssociation', ], ],
		],
		'DeleteDirectConnectGatewayRequest'                       => [
			'type'     => 'structure',
			'required' => [ 'directConnectGatewayId', ],
			'members'  => [ 'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ], ],
		],
		'DeleteDirectConnectGatewayResult'                        => [
			'type'    => 'structure',
			'members' => [ 'directConnectGateway' => [ 'shape' => 'DirectConnectGateway', ], ],
		],
		'DeleteInterconnectRequest'                               => [
			'type'     => 'structure',
			'required' => [ 'interconnectId', ],
			'members'  => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], ],
		],
		'DeleteInterconnectResponse'                              => [
			'type'    => 'structure',
			'members' => [ 'interconnectState' => [ 'shape' => 'InterconnectState', ], ],
		],
		'DeleteLagRequest'                                        => [
			'type'     => 'structure',
			'required' => [ 'lagId', ],
			'members'  => [ 'lagId' => [ 'shape' => 'LagId', ], ],
		],
		'DeleteVirtualInterfaceRequest'                           => [
			'type'     => 'structure',
			'required' => [ 'virtualInterfaceId', ],
			'members'  => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], ],
		],
		'DeleteVirtualInterfaceResponse'                          => [
			'type'    => 'structure',
			'members' => [ 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], ],
		],
		'DescribeConnectionLoaRequest'                            => [
			'type'     => 'structure',
			'required' => [ 'connectionId', ],
			'members'  => [
				'connectionId'   => [ 'shape' => 'ConnectionId', ],
				'providerName'   => [ 'shape' => 'ProviderName', ],
				'loaContentType' => [ 'shape' => 'LoaContentType', ],
			],
		],
		'DescribeConnectionLoaResponse'                           => [
			'type'    => 'structure',
			'members' => [ 'loa' => [ 'shape' => 'Loa', ], ],
		],
		'DescribeConnectionsOnInterconnectRequest'                => [
			'type'     => 'structure',
			'required' => [ 'interconnectId', ],
			'members'  => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], ],
		],
		'DescribeConnectionsRequest'                              => [
			'type'    => 'structure',
			'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ],
		],
		'DescribeDirectConnectGatewayAssociationProposalsRequest' => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'proposalId'             => [ 'shape' => 'DirectConnectGatewayAssociationProposalId', ],
				'associatedGatewayId'    => [ 'shape' => 'AssociatedGatewayId', ],
				'maxResults'             => [ 'shape' => 'MaxResultSetSize', ],
				'nextToken'              => [ 'shape' => 'PaginationToken', ],
			],
		],
		'DescribeDirectConnectGatewayAssociationProposalsResult'  => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayAssociationProposals' => [ 'shape' => 'DirectConnectGatewayAssociationProposalList', ],
				'nextToken'                                => [ 'shape' => 'PaginationToken', ],
			],
		],
		'DescribeDirectConnectGatewayAssociationsRequest'         => [
			'type'    => 'structure',
			'members' => [
				'associationId'          => [ 'shape' => 'DirectConnectGatewayAssociationId', ],
				'associatedGatewayId'    => [ 'shape' => 'AssociatedGatewayId', ],
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'maxResults'             => [ 'shape' => 'MaxResultSetSize', ],
				'nextToken'              => [ 'shape' => 'PaginationToken', ],
				'virtualGatewayId'       => [ 'shape' => 'VirtualGatewayId', ],
			],
		],
		'DescribeDirectConnectGatewayAssociationsResult'          => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayAssociations' => [ 'shape' => 'DirectConnectGatewayAssociationList', ],
				'nextToken'                        => [ 'shape' => 'PaginationToken', ],
			],
		],
		'DescribeDirectConnectGatewayAttachmentsRequest'          => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'virtualInterfaceId'     => [ 'shape' => 'VirtualInterfaceId', ],
				'maxResults'             => [ 'shape' => 'MaxResultSetSize', ],
				'nextToken'              => [ 'shape' => 'PaginationToken', ],
			],
		],
		'DescribeDirectConnectGatewayAttachmentsResult'           => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayAttachments' => [ 'shape' => 'DirectConnectGatewayAttachmentList', ],
				'nextToken'                       => [ 'shape' => 'PaginationToken', ],
			],
		],
		'DescribeDirectConnectGatewaysRequest'                    => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'maxResults'             => [ 'shape' => 'MaxResultSetSize', ],
				'nextToken'              => [ 'shape' => 'PaginationToken', ],
			],
		],
		'DescribeDirectConnectGatewaysResult'                     => [
			'type'    => 'structure',
			'members' => [
				'directConnectGateways' => [ 'shape' => 'DirectConnectGatewayList', ],
				'nextToken'             => [ 'shape' => 'PaginationToken', ],
			],
		],
		'DescribeHostedConnectionsRequest'                        => [
			'type'     => 'structure',
			'required' => [ 'connectionId', ],
			'members'  => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ],
		],
		'DescribeInterconnectLoaRequest'                          => [
			'type'     => 'structure',
			'required' => [ 'interconnectId', ],
			'members'  => [
				'interconnectId' => [ 'shape' => 'InterconnectId', ],
				'providerName'   => [ 'shape' => 'ProviderName', ],
				'loaContentType' => [ 'shape' => 'LoaContentType', ],
			],
		],
		'DescribeInterconnectLoaResponse'                         => [
			'type'    => 'structure',
			'members' => [ 'loa' => [ 'shape' => 'Loa', ], ],
		],
		'DescribeInterconnectsRequest'                            => [
			'type'    => 'structure',
			'members' => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], ],
		],
		'DescribeLagsRequest'                                     => [
			'type'    => 'structure',
			'members' => [ 'lagId' => [ 'shape' => 'LagId', ], ],
		],
		'DescribeLoaRequest'                                      => [
			'type'     => 'structure',
			'required' => [ 'connectionId', ],
			'members'  => [
				'connectionId'   => [ 'shape' => 'ConnectionId', ],
				'providerName'   => [ 'shape' => 'ProviderName', ],
				'loaContentType' => [ 'shape' => 'LoaContentType', ],
			],
		],
		'DescribeTagsRequest'                                     => [
			'type'     => 'structure',
			'required' => [ 'resourceArns', ],
			'members'  => [ 'resourceArns' => [ 'shape' => 'ResourceArnList', ], ],
		],
		'DescribeTagsResponse'                                    => [
			'type'    => 'structure',
			'members' => [ 'resourceTags' => [ 'shape' => 'ResourceTagList', ], ],
		],
		'DescribeVirtualInterfacesRequest'                        => [
			'type'    => 'structure',
			'members' => [
				'connectionId'       => [ 'shape' => 'ConnectionId', ],
				'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ],
			],
		],
		'DirectConnectClientException'                            => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'ErrorMessage', ], ],
			'exception' => true,
		],
		'DirectConnectGateway'                                    => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayId'    => [ 'shape' => 'DirectConnectGatewayId', ],
				'directConnectGatewayName'  => [ 'shape' => 'DirectConnectGatewayName', ],
				'amazonSideAsn'             => [ 'shape' => 'LongAsn', ],
				'ownerAccount'              => [ 'shape' => 'OwnerAccount', ],
				'directConnectGatewayState' => [ 'shape' => 'DirectConnectGatewayState', ],
				'stateChangeError'          => [ 'shape' => 'StateChangeError', ],
			],
		],
		'DirectConnectGatewayAssociation'                         => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayId'                => [ 'shape' => 'DirectConnectGatewayId', ],
				'directConnectGatewayOwnerAccount'      => [ 'shape' => 'OwnerAccount', ],
				'associationState'                      => [ 'shape' => 'DirectConnectGatewayAssociationState', ],
				'stateChangeError'                      => [ 'shape' => 'StateChangeError', ],
				'associatedGateway'                     => [ 'shape' => 'AssociatedGateway', ],
				'associationId'                         => [ 'shape' => 'DirectConnectGatewayAssociationId', ],
				'allowedPrefixesToDirectConnectGateway' => [ 'shape' => 'RouteFilterPrefixList', ],
				'virtualGatewayId'                      => [ 'shape' => 'VirtualGatewayId', ],
				'virtualGatewayRegion'                  => [ 'shape' => 'VirtualGatewayRegion', ],
				'virtualGatewayOwnerAccount'            => [ 'shape' => 'OwnerAccount', ],
			],
		],
		'DirectConnectGatewayAssociationId'                       => [ 'type' => 'string', ],
		'DirectConnectGatewayAssociationList'                     => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DirectConnectGatewayAssociation', ],
		],
		'DirectConnectGatewayAssociationProposal'                 => [
			'type'    => 'structure',
			'members' => [
				'proposalId'                                     => [ 'shape' => 'DirectConnectGatewayAssociationProposalId', ],
				'directConnectGatewayId'                         => [ 'shape' => 'DirectConnectGatewayId', ],
				'directConnectGatewayOwnerAccount'               => [ 'shape' => 'OwnerAccount', ],
				'proposalState'                                  => [ 'shape' => 'DirectConnectGatewayAssociationProposalState', ],
				'associatedGateway'                              => [ 'shape' => 'AssociatedGateway', ],
				'existingAllowedPrefixesToDirectConnectGateway'  => [ 'shape' => 'RouteFilterPrefixList', ],
				'requestedAllowedPrefixesToDirectConnectGateway' => [ 'shape' => 'RouteFilterPrefixList', ],
			],
		],
		'DirectConnectGatewayAssociationProposalId'               => [ 'type' => 'string', ],
		'DirectConnectGatewayAssociationProposalList'             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DirectConnectGatewayAssociationProposal', ],
		],
		'DirectConnectGatewayAssociationProposalState'            => [
			'type' => 'string',
			'enum' => [
				'requested',
				'accepted',
				'deleted',
			],
		],
		'DirectConnectGatewayAssociationState'                    => [
			'type' => 'string',
			'enum' => [
				'associating',
				'associated',
				'disassociating',
				'disassociated',
				'updating',
			],
		],
		'DirectConnectGatewayAttachment'                          => [
			'type'    => 'structure',
			'members' => [
				'directConnectGatewayId'       => [ 'shape' => 'DirectConnectGatewayId', ],
				'virtualInterfaceId'           => [ 'shape' => 'VirtualInterfaceId', ],
				'virtualInterfaceRegion'       => [ 'shape' => 'VirtualInterfaceRegion', ],
				'virtualInterfaceOwnerAccount' => [ 'shape' => 'OwnerAccount', ],
				'attachmentState'              => [ 'shape' => 'DirectConnectGatewayAttachmentState', ],
				'attachmentType'               => [ 'shape' => 'DirectConnectGatewayAttachmentType', ],
				'stateChangeError'             => [ 'shape' => 'StateChangeError', ],
			],
		],
		'DirectConnectGatewayAttachmentList'                      => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DirectConnectGatewayAttachment', ],
		],
		'DirectConnectGatewayAttachmentState'                     => [
			'type' => 'string',
			'enum' => [
				'attaching',
				'attached',
				'detaching',
				'detached',
			],
		],
		'DirectConnectGatewayAttachmentType'                      => [
			'type' => 'string',
			'enum' => [
				'TransitVirtualInterface',
				'PrivateVirtualInterface',
			],
		],
		'DirectConnectGatewayId'                                  => [ 'type' => 'string', ],
		'DirectConnectGatewayList'                                => [
			'type'   => 'list',
			'member' => [ 'shape' => 'DirectConnectGateway', ],
		],
		'DirectConnectGatewayName'                                => [ 'type' => 'string', ],
		'DirectConnectGatewayState'                               => [
			'type' => 'string',
			'enum' => [
				'pending',
				'available',
				'deleting',
				'deleted',
			],
		],
		'DirectConnectServerException'                            => [
			'type'      => 'structure',
			'members'   => [ 'message' => [ 'shape' => 'ErrorMessage', ], ],
			'exception' => true,
		],
		'DisassociateConnectionFromLagRequest'                    => [
			'type'     => 'structure',
			'required' => [ 'connectionId', 'lagId', ],
			'members'  => [
				'connectionId' => [ 'shape' => 'ConnectionId', ],
				'lagId'        => [ 'shape' => 'LagId', ],
			],
		],
		'DuplicateTagKeysException'                               => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'ErrorMessage'                                            => [ 'type' => 'string', ],
		'GatewayIdToAssociate'                                    => [ 'type' => 'string', ],
		'GatewayIdentifier'                                       => [ 'type' => 'string', ],
		'GatewayType'                                             => [
			'type' => 'string',
			'enum' => [
				'virtualPrivateGateway',
				'transitGateway',
			],
		],
		'HasLogicalRedundancy'                                    => [
			'type' => 'string',
			'enum' => [ 'unknown', 'yes', 'no', ],
		],
		'Interconnect'                                            => [
			'type'    => 'structure',
			'members' => [
				'interconnectId'       => [ 'shape' => 'InterconnectId', ],
				'interconnectName'     => [ 'shape' => 'InterconnectName', ],
				'interconnectState'    => [ 'shape' => 'InterconnectState', ],
				'region'               => [ 'shape' => 'Region', ],
				'location'             => [ 'shape' => 'LocationCode', ],
				'bandwidth'            => [ 'shape' => 'Bandwidth', ],
				'loaIssueTime'         => [ 'shape' => 'LoaIssueTime', ],
				'lagId'                => [ 'shape' => 'LagId', ],
				'awsDevice'            => [ 'shape' => 'AwsDevice', ],
				'jumboFrameCapable'    => [ 'shape' => 'JumboFrameCapable', ],
				'awsDeviceV2'          => [ 'shape' => 'AwsDeviceV2', ],
				'hasLogicalRedundancy' => [ 'shape' => 'HasLogicalRedundancy', ],
				'tags'                 => [ 'shape' => 'TagList', ],
			],
		],
		'InterconnectId'                                          => [ 'type' => 'string', ],
		'InterconnectList'                                        => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Interconnect', ],
		],
		'InterconnectName'                                        => [ 'type' => 'string', ],
		'InterconnectState'                                       => [
			'type' => 'string',
			'enum' => [
				'requested',
				'pending',
				'available',
				'down',
				'deleting',
				'deleted',
				'unknown',
			],
		],
		'Interconnects'                                           => [
			'type'    => 'structure',
			'members' => [ 'interconnects' => [ 'shape' => 'InterconnectList', ], ],
		],
		'JumboFrameCapable'                                       => [ 'type' => 'boolean', ],
		'Lag'                                                     => [
			'type'    => 'structure',
			'members' => [
				'connectionsBandwidth'    => [ 'shape' => 'Bandwidth', ],
				'numberOfConnections'     => [ 'shape' => 'Count', ],
				'lagId'                   => [ 'shape' => 'LagId', ],
				'ownerAccount'            => [ 'shape' => 'OwnerAccount', ],
				'lagName'                 => [ 'shape' => 'LagName', ],
				'lagState'                => [ 'shape' => 'LagState', ],
				'location'                => [ 'shape' => 'LocationCode', ],
				'region'                  => [ 'shape' => 'Region', ],
				'minimumLinks'            => [ 'shape' => 'Count', ],
				'awsDevice'               => [ 'shape' => 'AwsDevice', ],
				'awsDeviceV2'             => [ 'shape' => 'AwsDeviceV2', ],
				'connections'             => [ 'shape' => 'ConnectionList', ],
				'allowsHostedConnections' => [ 'shape' => 'BooleanFlag', ],
				'jumboFrameCapable'       => [ 'shape' => 'JumboFrameCapable', ],
				'hasLogicalRedundancy'    => [ 'shape' => 'HasLogicalRedundancy', ],
				'tags'                    => [ 'shape' => 'TagList', ],
			],
		],
		'LagId'                                                   => [ 'type' => 'string', ],
		'LagList'                                                 => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Lag', ],
		],
		'LagName'                                                 => [ 'type' => 'string', ],
		'LagState'                                                => [
			'type' => 'string',
			'enum' => [
				'requested',
				'pending',
				'available',
				'down',
				'deleting',
				'deleted',
				'unknown',
			],
		],
		'Lags'                                                    => [
			'type'    => 'structure',
			'members' => [ 'lags' => [ 'shape' => 'LagList', ], ],
		],
		'Loa'                                                     => [
			'type'    => 'structure',
			'members' => [
				'loaContent'     => [ 'shape' => 'LoaContent', ],
				'loaContentType' => [ 'shape' => 'LoaContentType', ],
			],
		],
		'LoaContent'                                              => [ 'type' => 'blob', ],
		'LoaContentType'                                          => [
			'type' => 'string',
			'enum' => [ 'application/pdf', ],
		],
		'LoaIssueTime'                                            => [ 'type' => 'timestamp', ],
		'Location'                                                => [
			'type'    => 'structure',
			'members' => [
				'locationCode'        => [ 'shape' => 'LocationCode', ],
				'locationName'        => [ 'shape' => 'LocationName', ],
				'region'              => [ 'shape' => 'Region', ],
				'availablePortSpeeds' => [ 'shape' => 'AvailablePortSpeeds', ],
			],
		],
		'LocationCode'                                            => [ 'type' => 'string', ],
		'LocationList'                                            => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Location', ],
		],
		'LocationName'                                            => [ 'type' => 'string', ],
		'Locations'                                               => [
			'type'    => 'structure',
			'members' => [ 'locations' => [ 'shape' => 'LocationList', ], ],
		],
		'LongAsn'                                                 => [ 'type' => 'long', ],
		'MTU'                                                     => [ 'type' => 'integer', ],
		'MaxResultSetSize'                                        => [ 'type' => 'integer', 'box' => true, ],
		'NewBGPPeer'                                              => [
			'type'    => 'structure',
			'members' => [
				'asn'             => [ 'shape' => 'ASN', ],
				'authKey'         => [ 'shape' => 'BGPAuthKey', ],
				'addressFamily'   => [ 'shape' => 'AddressFamily', ],
				'amazonAddress'   => [ 'shape' => 'AmazonAddress', ],
				'customerAddress' => [ 'shape' => 'CustomerAddress', ],
			],
		],
		'NewPrivateVirtualInterface'                              => [
			'type'     => 'structure',
			'required' => [
				'virtualInterfaceName',
				'vlan',
				'asn',
			],
			'members'  => [
				'virtualInterfaceName'   => [ 'shape' => 'VirtualInterfaceName', ],
				'vlan'                   => [ 'shape' => 'VLAN', ],
				'asn'                    => [ 'shape' => 'ASN', ],
				'mtu'                    => [ 'shape' => 'MTU', ],
				'authKey'                => [ 'shape' => 'BGPAuthKey', ],
				'amazonAddress'          => [ 'shape' => 'AmazonAddress', ],
				'customerAddress'        => [ 'shape' => 'CustomerAddress', ],
				'addressFamily'          => [ 'shape' => 'AddressFamily', ],
				'virtualGatewayId'       => [ 'shape' => 'VirtualGatewayId', ],
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'tags'                   => [ 'shape' => 'TagList', ],
			],
		],
		'NewPrivateVirtualInterfaceAllocation'                    => [
			'type'     => 'structure',
			'required' => [
				'virtualInterfaceName',
				'vlan',
				'asn',
			],
			'members'  => [
				'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ],
				'vlan'                 => [ 'shape' => 'VLAN', ],
				'asn'                  => [ 'shape' => 'ASN', ],
				'mtu'                  => [ 'shape' => 'MTU', ],
				'authKey'              => [ 'shape' => 'BGPAuthKey', ],
				'amazonAddress'        => [ 'shape' => 'AmazonAddress', ],
				'addressFamily'        => [ 'shape' => 'AddressFamily', ],
				'customerAddress'      => [ 'shape' => 'CustomerAddress', ],
				'tags'                 => [ 'shape' => 'TagList', ],
			],
		],
		'NewPublicVirtualInterface'                               => [
			'type'     => 'structure',
			'required' => [
				'virtualInterfaceName',
				'vlan',
				'asn',
			],
			'members'  => [
				'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ],
				'vlan'                 => [ 'shape' => 'VLAN', ],
				'asn'                  => [ 'shape' => 'ASN', ],
				'authKey'              => [ 'shape' => 'BGPAuthKey', ],
				'amazonAddress'        => [ 'shape' => 'AmazonAddress', ],
				'customerAddress'      => [ 'shape' => 'CustomerAddress', ],
				'addressFamily'        => [ 'shape' => 'AddressFamily', ],
				'routeFilterPrefixes'  => [ 'shape' => 'RouteFilterPrefixList', ],
				'tags'                 => [ 'shape' => 'TagList', ],
			],
		],
		'NewPublicVirtualInterfaceAllocation'                     => [
			'type'     => 'structure',
			'required' => [
				'virtualInterfaceName',
				'vlan',
				'asn',
			],
			'members'  => [
				'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ],
				'vlan'                 => [ 'shape' => 'VLAN', ],
				'asn'                  => [ 'shape' => 'ASN', ],
				'authKey'              => [ 'shape' => 'BGPAuthKey', ],
				'amazonAddress'        => [ 'shape' => 'AmazonAddress', ],
				'customerAddress'      => [ 'shape' => 'CustomerAddress', ],
				'addressFamily'        => [ 'shape' => 'AddressFamily', ],
				'routeFilterPrefixes'  => [ 'shape' => 'RouteFilterPrefixList', ],
				'tags'                 => [ 'shape' => 'TagList', ],
			],
		],
		'NewTransitVirtualInterface'                              => [
			'type'    => 'structure',
			'members' => [
				'virtualInterfaceName'   => [ 'shape' => 'VirtualInterfaceName', ],
				'vlan'                   => [ 'shape' => 'VLAN', ],
				'asn'                    => [ 'shape' => 'ASN', ],
				'mtu'                    => [ 'shape' => 'MTU', ],
				'authKey'                => [ 'shape' => 'BGPAuthKey', ],
				'amazonAddress'          => [ 'shape' => 'AmazonAddress', ],
				'customerAddress'        => [ 'shape' => 'CustomerAddress', ],
				'addressFamily'          => [ 'shape' => 'AddressFamily', ],
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'tags'                   => [ 'shape' => 'TagList', ],
			],
		],
		'NewTransitVirtualInterfaceAllocation'                    => [
			'type'    => 'structure',
			'members' => [
				'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ],
				'vlan'                 => [ 'shape' => 'VLAN', ],
				'asn'                  => [ 'shape' => 'ASN', ],
				'mtu'                  => [ 'shape' => 'MTU', ],
				'authKey'              => [ 'shape' => 'BGPAuthKey', ],
				'amazonAddress'        => [ 'shape' => 'AmazonAddress', ],
				'customerAddress'      => [ 'shape' => 'CustomerAddress', ],
				'addressFamily'        => [ 'shape' => 'AddressFamily', ],
				'tags'                 => [ 'shape' => 'TagList', ],
			],
		],
		'OwnerAccount'                                            => [ 'type' => 'string', ],
		'PaginationToken'                                         => [ 'type' => 'string', ],
		'PartnerName'                                             => [ 'type' => 'string', ],
		'PortSpeed'                                               => [ 'type' => 'string', ],
		'ProviderName'                                            => [ 'type' => 'string', ],
		'Region'                                                  => [ 'type' => 'string', ],
		'ResourceArn'                                             => [ 'type' => 'string', ],
		'ResourceArnList'                                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ResourceArn', ],
		],
		'ResourceTag'                                             => [
			'type'    => 'structure',
			'members' => [
				'resourceArn' => [ 'shape' => 'ResourceArn', ],
				'tags'        => [ 'shape' => 'TagList', ],
			],
		],
		'ResourceTagList'                                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ResourceTag', ],
		],
		'RouteFilterPrefix'                                       => [
			'type'    => 'structure',
			'members' => [ 'cidr' => [ 'shape' => 'CIDR', ], ],
		],
		'RouteFilterPrefixList'                                   => [
			'type'   => 'list',
			'member' => [ 'shape' => 'RouteFilterPrefix', ],
		],
		'RouterConfig'                                            => [ 'type' => 'string', ],
		'StateChangeError'                                        => [ 'type' => 'string', ],
		'Tag'                                                     => [
			'type'     => 'structure',
			'required' => [ 'key', ],
			'members'  => [
				'key'   => [ 'shape' => 'TagKey', ],
				'value' => [ 'shape' => 'TagValue', ],
			],
		],
		'TagKey'                                                  => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$',
		],
		'TagKeyList'                                              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'TagKey', ],
		],
		'TagList'                                                 => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Tag', ],
			'min'    => 1,
		],
		'TagResourceRequest'                                      => [
			'type'     => 'structure',
			'required' => [ 'resourceArn', 'tags', ],
			'members'  => [
				'resourceArn' => [ 'shape' => 'ResourceArn', ],
				'tags'        => [ 'shape' => 'TagList', ],
			],
		],
		'TagResourceResponse'                                     => [ 'type' => 'structure', 'members' => [], ],
		'TagValue'                                                => [
			'type'    => 'string',
			'max'     => 256,
			'min'     => 0,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$',
		],
		'TooManyTagsException'                                    => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'UntagResourceRequest'                                    => [
			'type'     => 'structure',
			'required' => [ 'resourceArn', 'tagKeys', ],
			'members'  => [
				'resourceArn' => [ 'shape' => 'ResourceArn', ],
				'tagKeys'     => [ 'shape' => 'TagKeyList', ],
			],
		],
		'UntagResourceResponse'                                   => [ 'type' => 'structure', 'members' => [], ],
		'UpdateDirectConnectGatewayAssociationRequest'            => [
			'type'    => 'structure',
			'members' => [
				'associationId'                               => [ 'shape' => 'DirectConnectGatewayAssociationId', ],
				'addAllowedPrefixesToDirectConnectGateway'    => [ 'shape' => 'RouteFilterPrefixList', ],
				'removeAllowedPrefixesToDirectConnectGateway' => [ 'shape' => 'RouteFilterPrefixList', ],
			],
		],
		'UpdateDirectConnectGatewayAssociationResult'             => [
			'type'    => 'structure',
			'members' => [ 'directConnectGatewayAssociation' => [ 'shape' => 'DirectConnectGatewayAssociation', ], ],
		],
		'UpdateLagRequest'                                        => [
			'type'     => 'structure',
			'required' => [ 'lagId', ],
			'members'  => [
				'lagId'        => [ 'shape' => 'LagId', ],
				'lagName'      => [ 'shape' => 'LagName', ],
				'minimumLinks' => [ 'shape' => 'Count', ],
			],
		],
		'UpdateVirtualInterfaceAttributesRequest'                 => [
			'type'     => 'structure',
			'required' => [ 'virtualInterfaceId', ],
			'members'  => [
				'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ],
				'mtu'                => [ 'shape' => 'MTU', ],
			],
		],
		'VLAN'                                                    => [ 'type' => 'integer', ],
		'VirtualGateway'                                          => [
			'type'    => 'structure',
			'members' => [
				'virtualGatewayId'    => [ 'shape' => 'VirtualGatewayId', ],
				'virtualGatewayState' => [ 'shape' => 'VirtualGatewayState', ],
			],
		],
		'VirtualGatewayId'                                        => [ 'type' => 'string', 'deprecated' => true, ],
		'VirtualGatewayList'                                      => [
			'type'   => 'list',
			'member' => [ 'shape' => 'VirtualGateway', ],
		],
		'VirtualGatewayRegion'                                    => [ 'type' => 'string', 'deprecated' => true, ],
		'VirtualGatewayState'                                     => [ 'type' => 'string', ],
		'VirtualGateways'                                         => [
			'type'    => 'structure',
			'members' => [ 'virtualGateways' => [ 'shape' => 'VirtualGatewayList', ], ],
		],
		'VirtualInterface'                                        => [
			'type'    => 'structure',
			'members' => [
				'ownerAccount'           => [ 'shape' => 'OwnerAccount', ],
				'virtualInterfaceId'     => [ 'shape' => 'VirtualInterfaceId', ],
				'location'               => [ 'shape' => 'LocationCode', ],
				'connectionId'           => [ 'shape' => 'ConnectionId', ],
				'virtualInterfaceType'   => [ 'shape' => 'VirtualInterfaceType', ],
				'virtualInterfaceName'   => [ 'shape' => 'VirtualInterfaceName', ],
				'vlan'                   => [ 'shape' => 'VLAN', ],
				'asn'                    => [ 'shape' => 'ASN', ],
				'amazonSideAsn'          => [ 'shape' => 'LongAsn', ],
				'authKey'                => [ 'shape' => 'BGPAuthKey', ],
				'amazonAddress'          => [ 'shape' => 'AmazonAddress', ],
				'customerAddress'        => [ 'shape' => 'CustomerAddress', ],
				'addressFamily'          => [ 'shape' => 'AddressFamily', ],
				'virtualInterfaceState'  => [ 'shape' => 'VirtualInterfaceState', ],
				'customerRouterConfig'   => [ 'shape' => 'RouterConfig', ],
				'mtu'                    => [ 'shape' => 'MTU', ],
				'jumboFrameCapable'      => [ 'shape' => 'JumboFrameCapable', ],
				'virtualGatewayId'       => [ 'shape' => 'VirtualGatewayId', ],
				'directConnectGatewayId' => [ 'shape' => 'DirectConnectGatewayId', ],
				'routeFilterPrefixes'    => [ 'shape' => 'RouteFilterPrefixList', ],
				'bgpPeers'               => [ 'shape' => 'BGPPeerList', ],
				'region'                 => [ 'shape' => 'Region', ],
				'awsDeviceV2'            => [ 'shape' => 'AwsDeviceV2', ],
				'tags'                   => [ 'shape' => 'TagList', ],
			],
		],
		'VirtualInterfaceId'                                      => [ 'type' => 'string', ],
		'VirtualInterfaceList'                                    => [
			'type'   => 'list',
			'member' => [ 'shape' => 'VirtualInterface', ],
		],
		'VirtualInterfaceName'                                    => [ 'type' => 'string', ],
		'VirtualInterfaceRegion'                                  => [ 'type' => 'string', ],
		'VirtualInterfaceState'                                   => [
			'type' => 'string',
			'enum' => [
				'confirming',
				'verifying',
				'pending',
				'available',
				'down',
				'deleting',
				'deleted',
				'rejected',
				'unknown',
			],
		],
		'VirtualInterfaceType'                                    => [ 'type' => 'string', ],
		'VirtualInterfaces'                                       => [
			'type'    => 'structure',
			'members' => [ 'virtualInterfaces' => [ 'shape' => 'VirtualInterfaceList', ], ],
		],
	],
];