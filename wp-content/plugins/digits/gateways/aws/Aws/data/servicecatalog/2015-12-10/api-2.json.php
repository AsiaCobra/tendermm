<?php
// This file was auto-generated from sdk-root/src/data/servicecatalog/2015-12-10/api-2.json
return [
	'version'    => '2.0',
	'metadata'   => [
		'apiVersion'       => '2015-12-10',
		'endpointPrefix'   => 'servicecatalog',
		'jsonVersion'      => '1.1',
		'protocol'         => 'json',
		'serviceFullName'  => 'AWS Service Catalog',
		'serviceId'        => 'Service Catalog',
		'signatureVersion' => 'v4',
		'targetPrefix'     => 'AWS242ServiceCatalogService',
		'uid'              => 'servicecatalog-2015-12-10',
	],
	'operations' => [
		'AcceptPortfolioShare'                                   => [
			'name'   => 'AcceptPortfolioShare',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AcceptPortfolioShareInput', ],
			'output' => [ 'shape' => 'AcceptPortfolioShareOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'AssociateBudgetWithResource'                            => [
			'name'   => 'AssociateBudgetWithResource',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociateBudgetWithResourceInput', ],
			'output' => [ 'shape' => 'AssociateBudgetWithResourceOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'DuplicateResourceException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'AssociatePrincipalWithPortfolio'                        => [
			'name'   => 'AssociatePrincipalWithPortfolio',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociatePrincipalWithPortfolioInput', ],
			'output' => [ 'shape' => 'AssociatePrincipalWithPortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'AssociateProductWithPortfolio'                          => [
			'name'   => 'AssociateProductWithPortfolio',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociateProductWithPortfolioInput', ],
			'output' => [ 'shape' => 'AssociateProductWithPortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'AssociateServiceActionWithProvisioningArtifact'         => [
			'name'   => 'AssociateServiceActionWithProvisioningArtifact',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociateServiceActionWithProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'AssociateServiceActionWithProvisioningArtifactOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'DuplicateResourceException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'AssociateTagOptionWithResource'                         => [
			'name'   => 'AssociateTagOptionWithResource',
			'http'   => [ 'method' => 'POST', 'requestUri' => '/', ],
			'input'  => [ 'shape' => 'AssociateTagOptionWithResourceInput', ],
			'output' => [ 'shape' => 'AssociateTagOptionWithResourceOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'DuplicateResourceException', ],
				[ 'shape' => 'InvalidStateException', ],
			],
		],
		'BatchAssociateServiceActionWithProvisioningArtifact'    => [
			'name'   => 'BatchAssociateServiceActionWithProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'BatchAssociateServiceActionWithProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'BatchAssociateServiceActionWithProvisioningArtifactOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'BatchDisassociateServiceActionFromProvisioningArtifact' => [
			'name'   => 'BatchDisassociateServiceActionFromProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'BatchDisassociateServiceActionFromProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'BatchDisassociateServiceActionFromProvisioningArtifactOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'CopyProduct'                                            => [
			'name'   => 'CopyProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CopyProductInput', ],
			'output' => [ 'shape' => 'CopyProductOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'CreateConstraint'                                       => [
			'name'   => 'CreateConstraint',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreateConstraintInput', ],
			'output' => [ 'shape' => 'CreateConstraintOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'DuplicateResourceException', ],
			],
		],
		'CreatePortfolio'                                        => [
			'name'   => 'CreatePortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreatePortfolioInput', ],
			'output' => [ 'shape' => 'CreatePortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'TagOptionNotMigratedException', ],
			],
		],
		'CreatePortfolioShare'                                   => [
			'name'   => 'CreatePortfolioShare',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreatePortfolioShareInput', ],
			'output' => [ 'shape' => 'CreatePortfolioShareOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
				[ 'shape' => 'InvalidStateException', ],
			],
		],
		'CreateProduct'                                          => [
			'name'   => 'CreateProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreateProductInput', ],
			'output' => [ 'shape' => 'CreateProductOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'TagOptionNotMigratedException', ],
			],
		],
		'CreateProvisionedProductPlan'                           => [
			'name'   => 'CreateProvisionedProductPlan',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreateProvisionedProductPlanInput', ],
			'output' => [ 'shape' => 'CreateProvisionedProductPlanOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidStateException', ],
			],
		],
		'CreateProvisioningArtifact'                             => [
			'name'   => 'CreateProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreateProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'CreateProvisioningArtifactOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'CreateServiceAction'                                    => [
			'name'   => 'CreateServiceAction',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreateServiceActionInput', ],
			'output' => [ 'shape' => 'CreateServiceActionOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'CreateTagOption'                                        => [
			'name'   => 'CreateTagOption',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'CreateTagOptionInput', ],
			'output' => [ 'shape' => 'CreateTagOptionOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'DuplicateResourceException', ],
				[ 'shape' => 'LimitExceededException', ],
			],
		],
		'DeleteConstraint'                                       => [
			'name'   => 'DeleteConstraint',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeleteConstraintInput', ],
			'output' => [ 'shape' => 'DeleteConstraintOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'DeletePortfolio'                                        => [
			'name'   => 'DeletePortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeletePortfolioInput', ],
			'output' => [ 'shape' => 'DeletePortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceInUseException', ],
				[ 'shape' => 'TagOptionNotMigratedException', ],
			],
		],
		'DeletePortfolioShare'                                   => [
			'name'   => 'DeletePortfolioShare',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeletePortfolioShareInput', ],
			'output' => [ 'shape' => 'DeletePortfolioShareOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
				[ 'shape' => 'InvalidStateException', ],
			],
		],
		'DeleteProduct'                                          => [
			'name'   => 'DeleteProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeleteProductInput', ],
			'output' => [ 'shape' => 'DeleteProductOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'ResourceInUseException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'TagOptionNotMigratedException', ],
			],
		],
		'DeleteProvisionedProductPlan'                           => [
			'name'   => 'DeleteProvisionedProductPlan',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeleteProvisionedProductPlanInput', ],
			'output' => [ 'shape' => 'DeleteProvisionedProductPlanOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'DeleteProvisioningArtifact'                             => [
			'name'   => 'DeleteProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeleteProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'DeleteProvisioningArtifactOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'ResourceInUseException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'DeleteServiceAction'                                    => [
			'name'   => 'DeleteServiceAction',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeleteServiceActionInput', ],
			'output' => [ 'shape' => 'DeleteServiceActionOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'ResourceInUseException', ],
			],
		],
		'DeleteTagOption'                                        => [
			'name'   => 'DeleteTagOption',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DeleteTagOptionInput', ],
			'output' => [ 'shape' => 'DeleteTagOptionOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'ResourceInUseException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'DescribeConstraint'                                     => [
			'name'   => 'DescribeConstraint',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeConstraintInput', ],
			'output' => [ 'shape' => 'DescribeConstraintOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribeCopyProductStatus'                              => [
			'name'   => 'DescribeCopyProductStatus',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeCopyProductStatusInput', ],
			'output' => [ 'shape' => 'DescribeCopyProductStatusOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribePortfolio'                                      => [
			'name'   => 'DescribePortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribePortfolioInput', ],
			'output' => [ 'shape' => 'DescribePortfolioOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribePortfolioShareStatus'                           => [
			'name'   => 'DescribePortfolioShareStatus',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribePortfolioShareStatusInput', ],
			'output' => [ 'shape' => 'DescribePortfolioShareStatusOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
			],
		],
		'DescribeProduct'                                        => [
			'name'   => 'DescribeProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeProductInput', ],
			'output' => [ 'shape' => 'DescribeProductOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'DescribeProductAsAdmin'                                 => [
			'name'   => 'DescribeProductAsAdmin',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeProductAsAdminInput', ],
			'output' => [ 'shape' => 'DescribeProductAsAdminOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribeProductView'                                    => [
			'name'   => 'DescribeProductView',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeProductViewInput', ],
			'output' => [ 'shape' => 'DescribeProductViewOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'DescribeProvisionedProduct'                             => [
			'name'   => 'DescribeProvisionedProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeProvisionedProductInput', ],
			'output' => [ 'shape' => 'DescribeProvisionedProductOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribeProvisionedProductPlan'                         => [
			'name'   => 'DescribeProvisionedProductPlan',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeProvisionedProductPlanInput', ],
			'output' => [ 'shape' => 'DescribeProvisionedProductPlanOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'DescribeProvisioningArtifact'                           => [
			'name'   => 'DescribeProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'DescribeProvisioningArtifactOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribeProvisioningParameters'                         => [
			'name'   => 'DescribeProvisioningParameters',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeProvisioningParametersInput', ],
			'output' => [ 'shape' => 'DescribeProvisioningParametersOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'DescribeRecord'                                         => [
			'name'   => 'DescribeRecord',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeRecordInput', ],
			'output' => [ 'shape' => 'DescribeRecordOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribeServiceAction'                                  => [
			'name'   => 'DescribeServiceAction',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeServiceActionInput', ],
			'output' => [ 'shape' => 'DescribeServiceActionOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DescribeServiceActionExecutionParameters'               => [
			'name'   => 'DescribeServiceActionExecutionParameters',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeServiceActionExecutionParametersInput', ],
			'output' => [ 'shape' => 'DescribeServiceActionExecutionParametersOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'DescribeTagOption'                                      => [
			'name'   => 'DescribeTagOption',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DescribeTagOptionInput', ],
			'output' => [ 'shape' => 'DescribeTagOptionOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'DisableAWSOrganizationsAccess'                          => [
			'name'   => 'DisableAWSOrganizationsAccess',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DisableAWSOrganizationsAccessInput', ],
			'output' => [ 'shape' => 'DisableAWSOrganizationsAccessOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidStateException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
			],
		],
		'DisassociateBudgetFromResource'                         => [
			'name'   => 'DisassociateBudgetFromResource',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DisassociateBudgetFromResourceInput', ],
			'output' => [ 'shape' => 'DisassociateBudgetFromResourceOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DisassociatePrincipalFromPortfolio'                     => [
			'name'   => 'DisassociatePrincipalFromPortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DisassociatePrincipalFromPortfolioInput', ],
			'output' => [ 'shape' => 'DisassociatePrincipalFromPortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'DisassociateProductFromPortfolio'                       => [
			'name'   => 'DisassociateProductFromPortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DisassociateProductFromPortfolioInput', ],
			'output' => [ 'shape' => 'DisassociateProductFromPortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'ResourceInUseException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'DisassociateServiceActionFromProvisioningArtifact'      => [
			'name'   => 'DisassociateServiceActionFromProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DisassociateServiceActionFromProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'DisassociateServiceActionFromProvisioningArtifactOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'DisassociateTagOptionFromResource'                      => [
			'name'   => 'DisassociateTagOptionFromResource',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'DisassociateTagOptionFromResourceInput', ],
			'output' => [ 'shape' => 'DisassociateTagOptionFromResourceOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'EnableAWSOrganizationsAccess'                           => [
			'name'   => 'EnableAWSOrganizationsAccess',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'EnableAWSOrganizationsAccessInput', ],
			'output' => [ 'shape' => 'EnableAWSOrganizationsAccessOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidStateException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
			],
		],
		'ExecuteProvisionedProductPlan'                          => [
			'name'   => 'ExecuteProvisionedProductPlan',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ExecuteProvisionedProductPlanInput', ],
			'output' => [ 'shape' => 'ExecuteProvisionedProductPlanOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidStateException', ],
			],
		],
		'ExecuteProvisionedProductServiceAction'                 => [
			'name'   => 'ExecuteProvisionedProductServiceAction',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ExecuteProvisionedProductServiceActionInput', ],
			'output' => [ 'shape' => 'ExecuteProvisionedProductServiceActionOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidStateException', ],
			],
		],
		'GetAWSOrganizationsAccessStatus'                        => [
			'name'   => 'GetAWSOrganizationsAccessStatus',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'GetAWSOrganizationsAccessStatusInput', ],
			'output' => [ 'shape' => 'GetAWSOrganizationsAccessStatusOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
			],
		],
		'ListAcceptedPortfolioShares'                            => [
			'name'   => 'ListAcceptedPortfolioShares',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListAcceptedPortfolioSharesInput', ],
			'output' => [ 'shape' => 'ListAcceptedPortfolioSharesOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
			],
		],
		'ListBudgetsForResource'                                 => [
			'name'   => 'ListBudgetsForResource',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListBudgetsForResourceInput', ],
			'output' => [ 'shape' => 'ListBudgetsForResourceOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListConstraintsForPortfolio'                            => [
			'name'   => 'ListConstraintsForPortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListConstraintsForPortfolioInput', ],
			'output' => [ 'shape' => 'ListConstraintsForPortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListLaunchPaths'                                        => [
			'name'   => 'ListLaunchPaths',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListLaunchPathsInput', ],
			'output' => [ 'shape' => 'ListLaunchPathsOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'ListOrganizationPortfolioAccess'                        => [
			'name'   => 'ListOrganizationPortfolioAccess',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListOrganizationPortfolioAccessInput', ],
			'output' => [ 'shape' => 'ListOrganizationPortfolioAccessOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'OperationNotSupportedException', ],
			],
		],
		'ListPortfolioAccess'                                    => [
			'name'   => 'ListPortfolioAccess',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListPortfolioAccessInput', ],
			'output' => [ 'shape' => 'ListPortfolioAccessOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'ListPortfolios'                                         => [
			'name'   => 'ListPortfolios',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListPortfoliosInput', ],
			'output' => [ 'shape' => 'ListPortfoliosOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'ListPortfoliosForProduct'                               => [
			'name'   => 'ListPortfoliosForProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListPortfoliosForProductInput', ],
			'output' => [ 'shape' => 'ListPortfoliosForProductOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'ListPrincipalsForPortfolio'                             => [
			'name'   => 'ListPrincipalsForPortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListPrincipalsForPortfolioInput', ],
			'output' => [ 'shape' => 'ListPrincipalsForPortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListProvisionedProductPlans'                            => [
			'name'   => 'ListProvisionedProductPlans',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListProvisionedProductPlansInput', ],
			'output' => [ 'shape' => 'ListProvisionedProductPlansOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListProvisioningArtifacts'                              => [
			'name'   => 'ListProvisioningArtifacts',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListProvisioningArtifactsInput', ],
			'output' => [ 'shape' => 'ListProvisioningArtifactsOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListProvisioningArtifactsForServiceAction'              => [
			'name'   => 'ListProvisioningArtifactsForServiceAction',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListProvisioningArtifactsForServiceActionInput', ],
			'output' => [ 'shape' => 'ListProvisioningArtifactsForServiceActionOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListRecordHistory'                                      => [
			'name'   => 'ListRecordHistory',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListRecordHistoryInput', ],
			'output' => [ 'shape' => 'ListRecordHistoryOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'ListResourcesForTagOption'                              => [
			'name'   => 'ListResourcesForTagOption',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListResourcesForTagOptionInput', ],
			'output' => [ 'shape' => 'ListResourcesForTagOptionOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListServiceActions'                                     => [
			'name'   => 'ListServiceActions',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListServiceActionsInput', ],
			'output' => [ 'shape' => 'ListServiceActionsOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'ListServiceActionsForProvisioningArtifact'              => [
			'name'   => 'ListServiceActionsForProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListServiceActionsForProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'ListServiceActionsForProvisioningArtifactOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ListStackInstancesForProvisionedProduct'                => [
			'name'   => 'ListStackInstancesForProvisionedProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListStackInstancesForProvisionedProductInput', ],
			'output' => [ 'shape' => 'ListStackInstancesForProvisionedProductOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'ListTagOptions'                                         => [
			'name'   => 'ListTagOptions',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ListTagOptionsInput', ],
			'output' => [ 'shape' => 'ListTagOptionsOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'ProvisionProduct'                                       => [
			'name'   => 'ProvisionProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ProvisionProductInput', ],
			'output' => [ 'shape' => 'ProvisionProductOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'DuplicateResourceException', ],
			],
		],
		'RejectPortfolioShare'                                   => [
			'name'   => 'RejectPortfolioShare',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'RejectPortfolioShareInput', ],
			'output' => [ 'shape' => 'RejectPortfolioShareOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'ScanProvisionedProducts'                                => [
			'name'   => 'ScanProvisionedProducts',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'ScanProvisionedProductsInput', ],
			'output' => [ 'shape' => 'ScanProvisionedProductsOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'SearchProducts'                                         => [
			'name'   => 'SearchProducts',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'SearchProductsInput', ],
			'output' => [ 'shape' => 'SearchProductsOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'SearchProductsAsAdmin'                                  => [
			'name'   => 'SearchProductsAsAdmin',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'SearchProductsAsAdminInput', ],
			'output' => [ 'shape' => 'SearchProductsAsAdminOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'SearchProvisionedProducts'                              => [
			'name'   => 'SearchProvisionedProducts',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'SearchProvisionedProductsInput', ],
			'output' => [ 'shape' => 'SearchProvisionedProductsOutput', ],
			'errors' => [ [ 'shape' => 'InvalidParametersException', ], ],
		],
		'TerminateProvisionedProduct'                            => [
			'name'   => 'TerminateProvisionedProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'TerminateProvisionedProductInput', ],
			'output' => [ 'shape' => 'TerminateProvisionedProductOutput', ],
			'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ],
		],
		'UpdateConstraint'                                       => [
			'name'   => 'UpdateConstraint',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateConstraintInput', ],
			'output' => [ 'shape' => 'UpdateConstraintOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'UpdatePortfolio'                                        => [
			'name'   => 'UpdatePortfolio',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdatePortfolioInput', ],
			'output' => [ 'shape' => 'UpdatePortfolioOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'LimitExceededException', ],
				[ 'shape' => 'TagOptionNotMigratedException', ],
			],
		],
		'UpdateProduct'                                          => [
			'name'   => 'UpdateProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateProductInput', ],
			'output' => [ 'shape' => 'UpdateProductOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'TagOptionNotMigratedException', ],
			],
		],
		'UpdateProvisionedProduct'                               => [
			'name'   => 'UpdateProvisionedProduct',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateProvisionedProductInput', ],
			'output' => [ 'shape' => 'UpdateProvisionedProductOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
			],
		],
		'UpdateProvisionedProductProperties'                     => [
			'name'   => 'UpdateProvisionedProductProperties',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateProvisionedProductPropertiesInput', ],
			'output' => [ 'shape' => 'UpdateProvisionedProductPropertiesOutput', ],
			'errors' => [
				[ 'shape' => 'InvalidParametersException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidStateException', ],
			],
		],
		'UpdateProvisioningArtifact'                             => [
			'name'   => 'UpdateProvisioningArtifact',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateProvisioningArtifactInput', ],
			'output' => [ 'shape' => 'UpdateProvisioningArtifactOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'UpdateServiceAction'                                    => [
			'name'   => 'UpdateServiceAction',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateServiceActionInput', ],
			'output' => [ 'shape' => 'UpdateServiceActionOutput', ],
			'errors' => [
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
		'UpdateTagOption'                                        => [
			'name'   => 'UpdateTagOption',
			'http'   => [
				'method'     => 'POST',
				'requestUri' => '/',
			],
			'input'  => [ 'shape' => 'UpdateTagOptionInput', ],
			'output' => [ 'shape' => 'UpdateTagOptionOutput', ],
			'errors' => [
				[ 'shape' => 'TagOptionNotMigratedException', ],
				[ 'shape' => 'ResourceNotFoundException', ],
				[ 'shape' => 'DuplicateResourceException', ],
				[ 'shape' => 'InvalidParametersException', ],
			],
		],
	],
	'shapes'     => [
		'AcceptLanguage'                                               => [ 'type' => 'string', 'max' => 100, ],
		'AcceptPortfolioShareInput'                                    => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage'     => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'        => [ 'shape' => 'Id', ],
				'PortfolioShareType' => [ 'shape' => 'PortfolioShareType', ],
			],
		],
		'AcceptPortfolioShareOutput'                                   => [ 'type' => 'structure', 'members' => [], ],
		'AccessLevelFilter'                                            => [
			'type'    => 'structure',
			'members' => [
				'Key'   => [ 'shape' => 'AccessLevelFilterKey', ],
				'Value' => [ 'shape' => 'AccessLevelFilterValue', ],
			],
		],
		'AccessLevelFilterKey'                                         => [
			'type' => 'string',
			'enum' => [ 'Account', 'Role', 'User', ],
		],
		'AccessLevelFilterValue'                                       => [ 'type' => 'string', ],
		'AccessStatus'                                                 => [
			'type' => 'string',
			'enum' => [ 'ENABLED', 'UNDER_CHANGE', 'DISABLED', ],
		],
		'AccountId'                                                    => [
			'type'    => 'string',
			'pattern' => '^[0-9]{12}$',
		],
		'AccountIds'                                                   => [
			'type'   => 'list',
			'member' => [ 'shape' => 'AccountId', ],
		],
		'AddTags'                                                      => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Tag', ],
			'max'    => 20,
		],
		'AllowedValue'                                                 => [ 'type' => 'string', ],
		'AllowedValues'                                                => [
			'type'   => 'list',
			'member' => [ 'shape' => 'AllowedValue', ],
		],
		'ApproximateCount'                                             => [ 'type' => 'integer', ],
		'AssociateBudgetWithResourceInput'                             => [
			'type'     => 'structure',
			'required' => [ 'BudgetName', 'ResourceId', ],
			'members'  => [
				'BudgetName' => [ 'shape' => 'BudgetName', ],
				'ResourceId' => [ 'shape' => 'Id', ],
			],
		],
		'AssociateBudgetWithResourceOutput'                            => [ 'type' => 'structure', 'members' => [], ],
		'AssociatePrincipalWithPortfolioInput'                         => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', 'PrincipalARN', 'PrincipalType', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'    => [ 'shape' => 'Id', ],
				'PrincipalARN'   => [ 'shape' => 'PrincipalARN', ],
				'PrincipalType'  => [ 'shape' => 'PrincipalType', ],
			],
		],
		'AssociatePrincipalWithPortfolioOutput'                        => [ 'type' => 'structure', 'members' => [], ],
		'AssociateProductWithPortfolioInput'                           => [
			'type'     => 'structure',
			'required' => [ 'ProductId', 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage'    => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'         => [ 'shape' => 'Id', ],
				'PortfolioId'       => [ 'shape' => 'Id', ],
				'SourcePortfolioId' => [ 'shape' => 'Id', ],
			],
		],
		'AssociateProductWithPortfolioOutput'                          => [ 'type' => 'structure', 'members' => [], ],
		'AssociateServiceActionWithProvisioningArtifactInput'          => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'ProvisioningArtifactId',
				'ServiceActionId',
			],
			'members'  => [
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'ServiceActionId'        => [ 'shape' => 'Id', ],
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'AssociateServiceActionWithProvisioningArtifactOutput'         => [ 'type' => 'structure', 'members' => [], ],
		'AssociateTagOptionWithResourceInput'                          => [
			'type'     => 'structure',
			'required' => [ 'ResourceId', 'TagOptionId', ],
			'members'  => [
				'ResourceId'  => [ 'shape' => 'ResourceId', ],
				'TagOptionId' => [ 'shape' => 'TagOptionId', ],
			],
		],
		'AssociateTagOptionWithResourceOutput'                         => [ 'type' => 'structure', 'members' => [], ],
		'AttributeValue'                                               => [ 'type' => 'string', ],
		'BatchAssociateServiceActionWithProvisioningArtifactInput'     => [
			'type'     => 'structure',
			'required' => [ 'ServiceActionAssociations', ],
			'members'  => [
				'ServiceActionAssociations' => [ 'shape' => 'ServiceActionAssociations', ],
				'AcceptLanguage'            => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'BatchAssociateServiceActionWithProvisioningArtifactOutput'    => [
			'type'    => 'structure',
			'members' => [ 'FailedServiceActionAssociations' => [ 'shape' => 'FailedServiceActionAssociations', ], ],
		],
		'BatchDisassociateServiceActionFromProvisioningArtifactInput'  => [
			'type'     => 'structure',
			'required' => [ 'ServiceActionAssociations', ],
			'members'  => [
				'ServiceActionAssociations' => [ 'shape' => 'ServiceActionAssociations', ],
				'AcceptLanguage'            => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'BatchDisassociateServiceActionFromProvisioningArtifactOutput' => [
			'type'    => 'structure',
			'members' => [ 'FailedServiceActionAssociations' => [ 'shape' => 'FailedServiceActionAssociations', ], ],
		],
		'BudgetDetail'                                                 => [
			'type'    => 'structure',
			'members' => [ 'BudgetName' => [ 'shape' => 'BudgetName', ], ],
		],
		'BudgetName'                                                   => [
			'type' => 'string',
			'max'  => 100,
			'min'  => 1,
		],
		'Budgets'                                                      => [
			'type'   => 'list',
			'member' => [ 'shape' => 'BudgetDetail', ],
		],
		'CausingEntity'                                                => [ 'type' => 'string', ],
		'ChangeAction'                                                 => [
			'type' => 'string',
			'enum' => [ 'ADD', 'MODIFY', 'REMOVE', ],
		],
		'CloudWatchDashboard'                                          => [
			'type'    => 'structure',
			'members' => [ 'Name' => [ 'shape' => 'CloudWatchDashboardName', ], ],
		],
		'CloudWatchDashboardName'                                      => [ 'type' => 'string', ],
		'CloudWatchDashboards'                                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'CloudWatchDashboard', ],
		],
		'ConstraintDescription'                                        => [ 'type' => 'string', 'max' => 2000, ],
		'ConstraintDetail'                                             => [
			'type'    => 'structure',
			'members' => [
				'ConstraintId' => [ 'shape' => 'Id', ],
				'Type'         => [ 'shape' => 'ConstraintType', ],
				'Description'  => [ 'shape' => 'ConstraintDescription', ],
				'Owner'        => [ 'shape' => 'AccountId', ],
			],
		],
		'ConstraintDetails'                                            => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ConstraintDetail', ],
		],
		'ConstraintParameters'                                         => [ 'type' => 'string', ],
		'ConstraintSummaries'                                          => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ConstraintSummary', ],
		],
		'ConstraintSummary'                                            => [
			'type'    => 'structure',
			'members' => [
				'Type'        => [ 'shape' => 'ConstraintType', ],
				'Description' => [ 'shape' => 'ConstraintDescription', ],
			],
		],
		'ConstraintType'                                               => [
			'type' => 'string',
			'max'  => 1024,
			'min'  => 1,
		],
		'CopyOption'                                                   => [
			'type' => 'string',
			'enum' => [ 'CopyTags', ],
		],
		'CopyOptions'                                                  => [
			'type'   => 'list',
			'member' => [ 'shape' => 'CopyOption', ],
		],
		'CopyProductInput'                                             => [
			'type'     => 'structure',
			'required' => [
				'SourceProductArn',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'                        => [ 'shape' => 'AcceptLanguage', ],
				'SourceProductArn'                      => [ 'shape' => 'ProductArn', ],
				'TargetProductId'                       => [ 'shape' => 'Id', ],
				'TargetProductName'                     => [ 'shape' => 'ProductViewName', ],
				'SourceProvisioningArtifactIdentifiers' => [ 'shape' => 'SourceProvisioningArtifactProperties', ],
				'CopyOptions'                           => [ 'shape' => 'CopyOptions', ],
				'IdempotencyToken'                      => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'CopyProductOutput'                                            => [
			'type'    => 'structure',
			'members' => [ 'CopyProductToken' => [ 'shape' => 'Id', ], ],
		],
		'CopyProductStatus'                                            => [
			'type' => 'string',
			'enum' => [
				'SUCCEEDED',
				'IN_PROGRESS',
				'FAILED',
			],
		],
		'CreateConstraintInput'                                        => [
			'type'     => 'structure',
			'required' => [
				'PortfolioId',
				'ProductId',
				'Parameters',
				'Type',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'      => [ 'shape' => 'Id', ],
				'ProductId'        => [ 'shape' => 'Id', ],
				'Parameters'       => [ 'shape' => 'ConstraintParameters', ],
				'Type'             => [ 'shape' => 'ConstraintType', ],
				'Description'      => [ 'shape' => 'ConstraintDescription', ],
				'IdempotencyToken' => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'CreateConstraintOutput'                                       => [
			'type'    => 'structure',
			'members' => [
				'ConstraintDetail'     => [ 'shape' => 'ConstraintDetail', ],
				'ConstraintParameters' => [ 'shape' => 'ConstraintParameters', ],
				'Status'               => [ 'shape' => 'Status', ],
			],
		],
		'CreatePortfolioInput'                                         => [
			'type'     => 'structure',
			'required' => [
				'DisplayName',
				'ProviderName',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'DisplayName'      => [ 'shape' => 'PortfolioDisplayName', ],
				'Description'      => [ 'shape' => 'PortfolioDescription', ],
				'ProviderName'     => [ 'shape' => 'ProviderName', ],
				'Tags'             => [ 'shape' => 'AddTags', ],
				'IdempotencyToken' => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'CreatePortfolioOutput'                                        => [
			'type'    => 'structure',
			'members' => [
				'PortfolioDetail' => [ 'shape' => 'PortfolioDetail', ],
				'Tags'            => [ 'shape' => 'Tags', ],
			],
		],
		'CreatePortfolioShareInput'                                    => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'      => [ 'shape' => 'Id', ],
				'AccountId'        => [ 'shape' => 'AccountId', ],
				'OrganizationNode' => [ 'shape' => 'OrganizationNode', ],
			],
		],
		'CreatePortfolioShareOutput'                                   => [
			'type'    => 'structure',
			'members' => [ 'PortfolioShareToken' => [ 'shape' => 'Id', ], ],
		],
		'CreateProductInput'                                           => [
			'type'     => 'structure',
			'required' => [
				'Name',
				'Owner',
				'ProductType',
				'ProvisioningArtifactParameters',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'                 => [ 'shape' => 'AcceptLanguage', ],
				'Name'                           => [ 'shape' => 'ProductViewName', ],
				'Owner'                          => [ 'shape' => 'ProductViewOwner', ],
				'Description'                    => [ 'shape' => 'ProductViewShortDescription', ],
				'Distributor'                    => [ 'shape' => 'ProductViewOwner', ],
				'SupportDescription'             => [ 'shape' => 'SupportDescription', ],
				'SupportEmail'                   => [ 'shape' => 'SupportEmail', ],
				'SupportUrl'                     => [ 'shape' => 'SupportUrl', ],
				'ProductType'                    => [ 'shape' => 'ProductType', ],
				'Tags'                           => [ 'shape' => 'AddTags', ],
				'ProvisioningArtifactParameters' => [ 'shape' => 'ProvisioningArtifactProperties', ],
				'IdempotencyToken'               => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'CreateProductOutput'                                          => [
			'type'    => 'structure',
			'members' => [
				'ProductViewDetail'          => [ 'shape' => 'ProductViewDetail', ],
				'ProvisioningArtifactDetail' => [ 'shape' => 'ProvisioningArtifactDetail', ],
				'Tags'                       => [ 'shape' => 'Tags', ],
			],
		],
		'CreateProvisionedProductPlanInput'                            => [
			'type'     => 'structure',
			'required' => [
				'PlanName',
				'PlanType',
				'ProductId',
				'ProvisionedProductName',
				'ProvisioningArtifactId',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
				'PlanName'               => [ 'shape' => 'ProvisionedProductPlanName', ],
				'PlanType'               => [ 'shape' => 'ProvisionedProductPlanType', ],
				'NotificationArns'       => [ 'shape' => 'NotificationArns', ],
				'PathId'                 => [ 'shape' => 'Id', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisionedProductName' => [ 'shape' => 'ProvisionedProductName', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'ProvisioningParameters' => [ 'shape' => 'UpdateProvisioningParameters', ],
				'IdempotencyToken'       => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
				'Tags'                   => [ 'shape' => 'Tags', ],
			],
		],
		'CreateProvisionedProductPlanOutput'                           => [
			'type'    => 'structure',
			'members' => [
				'PlanName'               => [ 'shape' => 'ProvisionedProductPlanName', ],
				'PlanId'                 => [ 'shape' => 'Id', ],
				'ProvisionProductId'     => [ 'shape' => 'Id', ],
				'ProvisionedProductName' => [ 'shape' => 'ProvisionedProductName', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
			],
		],
		'CreateProvisioningArtifactInput'                              => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'Parameters',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'        => [ 'shape' => 'Id', ],
				'Parameters'       => [ 'shape' => 'ProvisioningArtifactProperties', ],
				'IdempotencyToken' => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'CreateProvisioningArtifactOutput'                             => [
			'type'    => 'structure',
			'members' => [
				'ProvisioningArtifactDetail' => [ 'shape' => 'ProvisioningArtifactDetail', ],
				'Info'                       => [ 'shape' => 'ProvisioningArtifactInfo', ],
				'Status'                     => [ 'shape' => 'Status', ],
			],
		],
		'CreateServiceActionInput'                                     => [
			'type'     => 'structure',
			'required' => [
				'Name',
				'DefinitionType',
				'Definition',
				'IdempotencyToken',
			],
			'members'  => [
				'Name'             => [ 'shape' => 'ServiceActionName', ],
				'DefinitionType'   => [ 'shape' => 'ServiceActionDefinitionType', ],
				'Definition'       => [ 'shape' => 'ServiceActionDefinitionMap', ],
				'Description'      => [ 'shape' => 'ServiceActionDescription', ],
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'IdempotencyToken' => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'CreateServiceActionOutput'                                    => [
			'type'    => 'structure',
			'members' => [ 'ServiceActionDetail' => [ 'shape' => 'ServiceActionDetail', ], ],
		],
		'CreateTagOptionInput'                                         => [
			'type'     => 'structure',
			'required' => [ 'Key', 'Value', ],
			'members'  => [
				'Key'   => [ 'shape' => 'TagOptionKey', ],
				'Value' => [ 'shape' => 'TagOptionValue', ],
			],
		],
		'CreateTagOptionOutput'                                        => [
			'type'    => 'structure',
			'members' => [ 'TagOptionDetail' => [ 'shape' => 'TagOptionDetail', ], ],
		],
		'CreatedTime'                                                  => [ 'type' => 'timestamp', ],
		'CreationTime'                                                 => [ 'type' => 'timestamp', ],
		'DefaultValue'                                                 => [ 'type' => 'string', ],
		'DeleteConstraintInput'                                        => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DeleteConstraintOutput'                                       => [ 'type' => 'structure', 'members' => [], ],
		'DeletePortfolioInput'                                         => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DeletePortfolioOutput'                                        => [ 'type' => 'structure', 'members' => [], ],
		'DeletePortfolioShareInput'                                    => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'      => [ 'shape' => 'Id', ],
				'AccountId'        => [ 'shape' => 'AccountId', ],
				'OrganizationNode' => [ 'shape' => 'OrganizationNode', ],
			],
		],
		'DeletePortfolioShareOutput'                                   => [
			'type'    => 'structure',
			'members' => [ 'PortfolioShareToken' => [ 'shape' => 'Id', ], ],
		],
		'DeleteProductInput'                                           => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DeleteProductOutput'                                          => [ 'type' => 'structure', 'members' => [], ],
		'DeleteProvisionedProductPlanInput'                            => [
			'type'     => 'structure',
			'required' => [ 'PlanId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PlanId'         => [ 'shape' => 'Id', ],
				'IgnoreErrors'   => [ 'shape' => 'IgnoreErrors', ],
			],
		],
		'DeleteProvisionedProductPlanOutput'                           => [ 'type' => 'structure', 'members' => [], ],
		'DeleteProvisioningArtifactInput'                              => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'ProvisioningArtifactId',
			],
			'members'  => [
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
			],
		],
		'DeleteProvisioningArtifactOutput'                             => [ 'type' => 'structure', 'members' => [], ],
		'DeleteServiceActionInput'                                     => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'Id'             => [ 'shape' => 'Id', ],
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'DeleteServiceActionOutput'                                    => [ 'type' => 'structure', 'members' => [], ],
		'DeleteTagOptionInput'                                         => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [ 'Id' => [ 'shape' => 'TagOptionId', ], ],
		],
		'DeleteTagOptionOutput'                                        => [ 'type' => 'structure', 'members' => [], ],
		'DescribeConstraintInput'                                      => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DescribeConstraintOutput'                                     => [
			'type'    => 'structure',
			'members' => [
				'ConstraintDetail'     => [ 'shape' => 'ConstraintDetail', ],
				'ConstraintParameters' => [ 'shape' => 'ConstraintParameters', ],
				'Status'               => [ 'shape' => 'Status', ],
			],
		],
		'DescribeCopyProductStatusInput'                               => [
			'type'     => 'structure',
			'required' => [ 'CopyProductToken', ],
			'members'  => [
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'CopyProductToken' => [ 'shape' => 'Id', ],
			],
		],
		'DescribeCopyProductStatusOutput'                              => [
			'type'    => 'structure',
			'members' => [
				'CopyProductStatus' => [ 'shape' => 'CopyProductStatus', ],
				'TargetProductId'   => [ 'shape' => 'Id', ],
				'StatusDetail'      => [ 'shape' => 'StatusDetail', ],
			],
		],
		'DescribePortfolioInput'                                       => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DescribePortfolioOutput'                                      => [
			'type'    => 'structure',
			'members' => [
				'PortfolioDetail' => [ 'shape' => 'PortfolioDetail', ],
				'Tags'            => [ 'shape' => 'Tags', ],
				'TagOptions'      => [ 'shape' => 'TagOptionDetails', ],
				'Budgets'         => [ 'shape' => 'Budgets', ],
			],
		],
		'DescribePortfolioShareStatusInput'                            => [
			'type'     => 'structure',
			'required' => [ 'PortfolioShareToken', ],
			'members'  => [ 'PortfolioShareToken' => [ 'shape' => 'Id', ], ],
		],
		'DescribePortfolioShareStatusOutput'                           => [
			'type'    => 'structure',
			'members' => [
				'PortfolioShareToken'   => [ 'shape' => 'Id', ],
				'PortfolioId'           => [ 'shape' => 'Id', ],
				'OrganizationNodeValue' => [ 'shape' => 'OrganizationNodeValue', ],
				'Status'                => [ 'shape' => 'ShareStatus', ],
				'ShareDetails'          => [ 'shape' => 'ShareDetails', ],
			],
		],
		'DescribeProductAsAdminInput'                                  => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DescribeProductAsAdminOutput'                                 => [
			'type'    => 'structure',
			'members' => [
				'ProductViewDetail'             => [ 'shape' => 'ProductViewDetail', ],
				'ProvisioningArtifactSummaries' => [ 'shape' => 'ProvisioningArtifactSummaries', ],
				'Tags'                          => [ 'shape' => 'Tags', ],
				'TagOptions'                    => [ 'shape' => 'TagOptionDetails', ],
				'Budgets'                       => [ 'shape' => 'Budgets', ],
			],
		],
		'DescribeProductInput'                                         => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DescribeProductOutput'                                        => [
			'type'    => 'structure',
			'members' => [
				'ProductViewSummary'    => [ 'shape' => 'ProductViewSummary', ],
				'ProvisioningArtifacts' => [ 'shape' => 'ProvisioningArtifacts', ],
				'Budgets'               => [ 'shape' => 'Budgets', ],
			],
		],
		'DescribeProductViewInput'                                     => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DescribeProductViewOutput'                                    => [
			'type'    => 'structure',
			'members' => [
				'ProductViewSummary'    => [ 'shape' => 'ProductViewSummary', ],
				'ProvisioningArtifacts' => [ 'shape' => 'ProvisioningArtifacts', ],
			],
		],
		'DescribeProvisionedProductInput'                              => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
			],
		],
		'DescribeProvisionedProductOutput'                             => [
			'type'    => 'structure',
			'members' => [
				'ProvisionedProductDetail' => [ 'shape' => 'ProvisionedProductDetail', ],
				'CloudWatchDashboards'     => [ 'shape' => 'CloudWatchDashboards', ],
			],
		],
		'DescribeProvisionedProductPlanInput'                          => [
			'type'     => 'structure',
			'required' => [ 'PlanId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PlanId'         => [ 'shape' => 'Id', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'DescribeProvisionedProductPlanOutput'                         => [
			'type'    => 'structure',
			'members' => [
				'ProvisionedProductPlanDetails' => [ 'shape' => 'ProvisionedProductPlanDetails', ],
				'ResourceChanges'               => [ 'shape' => 'ResourceChanges', ],
				'NextPageToken'                 => [ 'shape' => 'PageToken', ],
			],
		],
		'DescribeProvisioningArtifactInput'                            => [
			'type'     => 'structure',
			'required' => [
				'ProvisioningArtifactId',
				'ProductId',
			],
			'members'  => [
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'Verbose'                => [ 'shape' => 'Verbose', ],
			],
		],
		'DescribeProvisioningArtifactOutput'                           => [
			'type'    => 'structure',
			'members' => [
				'ProvisioningArtifactDetail' => [ 'shape' => 'ProvisioningArtifactDetail', ],
				'Info'                       => [ 'shape' => 'ProvisioningArtifactInfo', ],
				'Status'                     => [ 'shape' => 'Status', ],
			],
		],
		'DescribeProvisioningParametersInput'                          => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'ProvisioningArtifactId',
			],
			'members'  => [
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'PathId'                 => [ 'shape' => 'Id', ],
			],
		],
		'DescribeProvisioningParametersOutput'                         => [
			'type'    => 'structure',
			'members' => [
				'ProvisioningArtifactParameters'  => [ 'shape' => 'ProvisioningArtifactParameters', ],
				'ConstraintSummaries'             => [ 'shape' => 'ConstraintSummaries', ],
				'UsageInstructions'               => [ 'shape' => 'UsageInstructions', ],
				'TagOptions'                      => [ 'shape' => 'TagOptionSummaries', ],
				'ProvisioningArtifactPreferences' => [ 'shape' => 'ProvisioningArtifactPreferences', ],
			],
		],
		'DescribeRecordInput'                                          => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
			],
		],
		'DescribeRecordOutput'                                         => [
			'type'    => 'structure',
			'members' => [
				'RecordDetail'  => [ 'shape' => 'RecordDetail', ],
				'RecordOutputs' => [ 'shape' => 'RecordOutputs', ],
				'NextPageToken' => [ 'shape' => 'PageToken', ],
			],
		],
		'DescribeServiceActionExecutionParametersInput'                => [
			'type'     => 'structure',
			'required' => [
				'ProvisionedProductId',
				'ServiceActionId',
			],
			'members'  => [
				'ProvisionedProductId' => [ 'shape' => 'Id', ],
				'ServiceActionId'      => [ 'shape' => 'Id', ],
				'AcceptLanguage'       => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'DescribeServiceActionExecutionParametersOutput'               => [
			'type'    => 'structure',
			'members' => [ 'ServiceActionParameters' => [ 'shape' => 'ExecutionParameters', ], ],
		],
		'DescribeServiceActionInput'                                   => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'Id'             => [ 'shape' => 'Id', ],
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'DescribeServiceActionOutput'                                  => [
			'type'    => 'structure',
			'members' => [ 'ServiceActionDetail' => [ 'shape' => 'ServiceActionDetail', ], ],
		],
		'DescribeTagOptionInput'                                       => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [ 'Id' => [ 'shape' => 'TagOptionId', ], ],
		],
		'DescribeTagOptionOutput'                                      => [
			'type'    => 'structure',
			'members' => [ 'TagOptionDetail' => [ 'shape' => 'TagOptionDetail', ], ],
		],
		'Description'                                                  => [ 'type' => 'string', ],
		'DisableAWSOrganizationsAccessInput'                           => [ 'type' => 'structure', 'members' => [], ],
		'DisableAWSOrganizationsAccessOutput'                          => [ 'type' => 'structure', 'members' => [], ],
		'DisableTemplateValidation'                                    => [ 'type' => 'boolean', ],
		'DisassociateBudgetFromResourceInput'                          => [
			'type'     => 'structure',
			'required' => [
				'BudgetName',
				'ResourceId',
			],
			'members'  => [
				'BudgetName' => [ 'shape' => 'BudgetName', ],
				'ResourceId' => [ 'shape' => 'Id', ],
			],
		],
		'DisassociateBudgetFromResourceOutput'                         => [ 'type' => 'structure', 'members' => [], ],
		'DisassociatePrincipalFromPortfolioInput'                      => [
			'type'     => 'structure',
			'required' => [
				'PortfolioId',
				'PrincipalARN',
			],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'    => [ 'shape' => 'Id', ],
				'PrincipalARN'   => [ 'shape' => 'PrincipalARN', ],
			],
		],
		'DisassociatePrincipalFromPortfolioOutput'                     => [ 'type' => 'structure', 'members' => [], ],
		'DisassociateProductFromPortfolioInput'                        => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'PortfolioId',
			],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'      => [ 'shape' => 'Id', ],
				'PortfolioId'    => [ 'shape' => 'Id', ],
			],
		],
		'DisassociateProductFromPortfolioOutput'                       => [ 'type' => 'structure', 'members' => [], ],
		'DisassociateServiceActionFromProvisioningArtifactInput'       => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'ProvisioningArtifactId',
				'ServiceActionId',
			],
			'members'  => [
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'ServiceActionId'        => [ 'shape' => 'Id', ],
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'DisassociateServiceActionFromProvisioningArtifactOutput'      => [ 'type' => 'structure', 'members' => [], ],
		'DisassociateTagOptionFromResourceInput'                       => [
			'type'     => 'structure',
			'required' => [
				'ResourceId',
				'TagOptionId',
			],
			'members'  => [
				'ResourceId'  => [ 'shape' => 'ResourceId', ],
				'TagOptionId' => [ 'shape' => 'TagOptionId', ],
			],
		],
		'DisassociateTagOptionFromResourceOutput'                      => [ 'type' => 'structure', 'members' => [], ],
		'DuplicateResourceException'                                   => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'EnableAWSOrganizationsAccessInput'                            => [ 'type' => 'structure', 'members' => [], ],
		'EnableAWSOrganizationsAccessOutput'                           => [ 'type' => 'structure', 'members' => [], ],
		'Error'                                                        => [ 'type' => 'string', ],
		'ErrorCode'                                                    => [ 'type' => 'string', ],
		'ErrorDescription'                                             => [ 'type' => 'string', ],
		'EvaluationType'                                               => [
			'type' => 'string',
			'enum' => [ 'STATIC', 'DYNAMIC', ],
		],
		'ExecuteProvisionedProductPlanInput'                           => [
			'type'     => 'structure',
			'required' => [
				'PlanId',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'   => [ 'shape' => 'AcceptLanguage', ],
				'PlanId'           => [ 'shape' => 'Id', ],
				'IdempotencyToken' => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'ExecuteProvisionedProductPlanOutput'                          => [
			'type'    => 'structure',
			'members' => [ 'RecordDetail' => [ 'shape' => 'RecordDetail', ], ],
		],
		'ExecuteProvisionedProductServiceActionInput'                  => [
			'type'     => 'structure',
			'required' => [
				'ProvisionedProductId',
				'ServiceActionId',
				'ExecuteToken',
			],
			'members'  => [
				'ProvisionedProductId' => [ 'shape' => 'Id', ],
				'ServiceActionId'      => [ 'shape' => 'Id', ],
				'ExecuteToken'         => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
				'AcceptLanguage'       => [ 'shape' => 'AcceptLanguage', ],
				'Parameters'           => [ 'shape' => 'ExecutionParameterMap', ],
			],
		],
		'ExecuteProvisionedProductServiceActionOutput'                 => [
			'type'    => 'structure',
			'members' => [ 'RecordDetail' => [ 'shape' => 'RecordDetail', ], ],
		],
		'ExecutionParameter'                                           => [
			'type'    => 'structure',
			'members' => [
				'Name'          => [ 'shape' => 'ExecutionParameterKey', ],
				'Type'          => [ 'shape' => 'ExecutionParameterType', ],
				'DefaultValues' => [ 'shape' => 'ExecutionParameterValueList', ],
			],
		],
		'ExecutionParameterKey'                                        => [
			'type' => 'string',
			'max'  => 50,
			'min'  => 1,
		],
		'ExecutionParameterMap'                                        => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'ExecutionParameterKey', ],
			'value' => [ 'shape' => 'ExecutionParameterValueList', ],
			'max'   => 200,
			'min'   => 1,
		],
		'ExecutionParameterType'                                       => [
			'type' => 'string',
			'max'  => 1024,
			'min'  => 1,
		],
		'ExecutionParameterValue'                                      => [
			'type' => 'string',
			'max'  => 512,
			'min'  => 0,
		],
		'ExecutionParameterValueList'                                  => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ExecutionParameterValue', ],
			'max'    => 25,
			'min'    => 0,
		],
		'ExecutionParameters'                                          => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ExecutionParameter', ],
		],
		'FailedServiceActionAssociation'                               => [
			'type'    => 'structure',
			'members' => [
				'ServiceActionId'        => [ 'shape' => 'Id', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'ErrorCode'              => [ 'shape' => 'ServiceActionAssociationErrorCode', ],
				'ErrorMessage'           => [ 'shape' => 'ServiceActionAssociationErrorMessage', ],
			],
		],
		'FailedServiceActionAssociations'                              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'FailedServiceActionAssociation', ],
			'max'    => 50,
		],
		'GetAWSOrganizationsAccessStatusInput'                         => [ 'type' => 'structure', 'members' => [], ],
		'GetAWSOrganizationsAccessStatusOutput'                        => [
			'type'    => 'structure',
			'members' => [ 'AccessStatus' => [ 'shape' => 'AccessStatus', ], ],
		],
		'HasDefaultPath'                                               => [ 'type' => 'boolean', ],
		'Id'                                                           => [
			'type'    => 'string',
			'max'     => 100,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_\\-]*',
		],
		'IdempotencyToken'                                             => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
		],
		'IgnoreErrors'                                                 => [ 'type' => 'boolean', ],
		'InstructionType'                                              => [ 'type' => 'string', ],
		'InstructionValue'                                             => [ 'type' => 'string', ],
		'InvalidParametersException'                                   => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'InvalidStateException'                                        => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'LastRequestId'                                                => [ 'type' => 'string', ],
		'LaunchPathSummaries'                                          => [
			'type'   => 'list',
			'member' => [ 'shape' => 'LaunchPathSummary', ],
		],
		'LaunchPathSummary'                                            => [
			'type'    => 'structure',
			'members' => [
				'Id'                  => [ 'shape' => 'Id', ],
				'ConstraintSummaries' => [ 'shape' => 'ConstraintSummaries', ],
				'Tags'                => [ 'shape' => 'Tags', ],
				'Name'                => [ 'shape' => 'PortfolioName', ],
			],
		],
		'LimitExceededException'                                       => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'ListAcceptedPortfolioSharesInput'                             => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage'     => [ 'shape' => 'AcceptLanguage', ],
				'PageToken'          => [ 'shape' => 'PageToken', ],
				'PageSize'           => [ 'shape' => 'PageSize', ],
				'PortfolioShareType' => [ 'shape' => 'PortfolioShareType', ],
			],
		],
		'ListAcceptedPortfolioSharesOutput'                            => [
			'type'    => 'structure',
			'members' => [
				'PortfolioDetails' => [ 'shape' => 'PortfolioDetails', ],
				'NextPageToken'    => [ 'shape' => 'PageToken', ],
			],
		],
		'ListBudgetsForResourceInput'                                  => [
			'type'     => 'structure',
			'required' => [ 'ResourceId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'ResourceId'     => [ 'shape' => 'Id', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'ListBudgetsForResourceOutput'                                 => [
			'type'    => 'structure',
			'members' => [
				'Budgets'       => [ 'shape' => 'Budgets', ],
				'NextPageToken' => [ 'shape' => 'PageToken', ],
			],
		],
		'ListConstraintsForPortfolioInput'                             => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'    => [ 'shape' => 'Id', ],
				'ProductId'      => [ 'shape' => 'Id', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'ListConstraintsForPortfolioOutput'                            => [
			'type'    => 'structure',
			'members' => [
				'ConstraintDetails' => [ 'shape' => 'ConstraintDetails', ],
				'NextPageToken'     => [ 'shape' => 'PageToken', ],
			],
		],
		'ListLaunchPathsInput'                                         => [
			'type'     => 'structure',
			'required' => [ 'ProductId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'      => [ 'shape' => 'Id', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'ListLaunchPathsOutput'                                        => [
			'type'    => 'structure',
			'members' => [
				'LaunchPathSummaries' => [ 'shape' => 'LaunchPathSummaries', ],
				'NextPageToken'       => [ 'shape' => 'PageToken', ],
			],
		],
		'ListOrganizationPortfolioAccessInput'                         => [
			'type'     => 'structure',
			'required' => [
				'PortfolioId',
				'OrganizationNodeType',
			],
			'members'  => [
				'AcceptLanguage'       => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'          => [ 'shape' => 'Id', ],
				'OrganizationNodeType' => [ 'shape' => 'OrganizationNodeType', ],
				'PageToken'            => [ 'shape' => 'PageToken', ],
				'PageSize'             => [ 'shape' => 'PageSize', ],
			],
		],
		'ListOrganizationPortfolioAccessOutput'                        => [
			'type'    => 'structure',
			'members' => [
				'OrganizationNodes' => [ 'shape' => 'OrganizationNodes', ],
				'NextPageToken'     => [ 'shape' => 'PageToken', ],
			],
		],
		'ListPortfolioAccessInput'                                     => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'    => [ 'shape' => 'Id', ],
			],
		],
		'ListPortfolioAccessOutput'                                    => [
			'type'    => 'structure',
			'members' => [
				'AccountIds'    => [ 'shape' => 'AccountIds', ],
				'NextPageToken' => [ 'shape' => 'PageToken', ],
			],
		],
		'ListPortfoliosForProductInput'                                => [
			'type'     => 'structure',
			'required' => [ 'ProductId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'      => [ 'shape' => 'Id', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
			],
		],
		'ListPortfoliosForProductOutput'                               => [
			'type'    => 'structure',
			'members' => [
				'PortfolioDetails' => [ 'shape' => 'PortfolioDetails', ],
				'NextPageToken'    => [ 'shape' => 'PageToken', ],
			],
		],
		'ListPortfoliosInput'                                          => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
			],
		],
		'ListPortfoliosOutput'                                         => [
			'type'    => 'structure',
			'members' => [
				'PortfolioDetails' => [ 'shape' => 'PortfolioDetails', ],
				'NextPageToken'    => [ 'shape' => 'PageToken', ],
			],
		],
		'ListPrincipalsForPortfolioInput'                              => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'    => [ 'shape' => 'Id', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'ListPrincipalsForPortfolioOutput'                             => [
			'type'    => 'structure',
			'members' => [
				'Principals'    => [ 'shape' => 'Principals', ],
				'NextPageToken' => [ 'shape' => 'PageToken', ],
			],
		],
		'ListProvisionedProductPlansInput'                             => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage'     => [ 'shape' => 'AcceptLanguage', ],
				'ProvisionProductId' => [ 'shape' => 'Id', ],
				'PageSize'           => [ 'shape' => 'PageSize', ],
				'PageToken'          => [ 'shape' => 'PageToken', ],
				'AccessLevelFilter'  => [ 'shape' => 'AccessLevelFilter', ],
			],
		],
		'ListProvisionedProductPlansOutput'                            => [
			'type'    => 'structure',
			'members' => [
				'ProvisionedProductPlans' => [ 'shape' => 'ProvisionedProductPlans', ],
				'NextPageToken'           => [ 'shape' => 'PageToken', ],
			],
		],
		'ListProvisioningArtifactsForServiceActionInput'               => [
			'type'     => 'structure',
			'required' => [ 'ServiceActionId', ],
			'members'  => [
				'ServiceActionId' => [ 'shape' => 'Id', ],
				'PageSize'        => [ 'shape' => 'PageSize', ],
				'PageToken'       => [ 'shape' => 'PageToken', ],
				'AcceptLanguage'  => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'ListProvisioningArtifactsForServiceActionOutput'              => [
			'type'    => 'structure',
			'members' => [
				'ProvisioningArtifactViews' => [ 'shape' => 'ProvisioningArtifactViews', ],
				'NextPageToken'             => [ 'shape' => 'PageToken', ],
			],
		],
		'ListProvisioningArtifactsInput'                               => [
			'type'     => 'structure',
			'required' => [ 'ProductId', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'      => [ 'shape' => 'Id', ],
			],
		],
		'ListProvisioningArtifactsOutput'                              => [
			'type'    => 'structure',
			'members' => [
				'ProvisioningArtifactDetails' => [ 'shape' => 'ProvisioningArtifactDetails', ],
				'NextPageToken'               => [ 'shape' => 'PageToken', ],
			],
		],
		'ListRecordHistoryInput'                                       => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage'    => [ 'shape' => 'AcceptLanguage', ],
				'AccessLevelFilter' => [ 'shape' => 'AccessLevelFilter', ],
				'SearchFilter'      => [ 'shape' => 'ListRecordHistorySearchFilter', ],
				'PageSize'          => [ 'shape' => 'PageSize', ],
				'PageToken'         => [ 'shape' => 'PageToken', ],
			],
		],
		'ListRecordHistoryOutput'                                      => [
			'type'    => 'structure',
			'members' => [
				'RecordDetails' => [ 'shape' => 'RecordDetails', ],
				'NextPageToken' => [ 'shape' => 'PageToken', ],
			],
		],
		'ListRecordHistorySearchFilter'                                => [
			'type'    => 'structure',
			'members' => [
				'Key'   => [ 'shape' => 'SearchFilterKey', ],
				'Value' => [ 'shape' => 'SearchFilterValue', ],
			],
		],
		'ListResourcesForTagOptionInput'                               => [
			'type'     => 'structure',
			'required' => [ 'TagOptionId', ],
			'members'  => [
				'TagOptionId'  => [ 'shape' => 'TagOptionId', ],
				'ResourceType' => [ 'shape' => 'ResourceType', ],
				'PageSize'     => [ 'shape' => 'PageSize', ],
				'PageToken'    => [ 'shape' => 'PageToken', ],
			],
		],
		'ListResourcesForTagOptionOutput'                              => [
			'type'    => 'structure',
			'members' => [
				'ResourceDetails' => [ 'shape' => 'ResourceDetails', ],
				'PageToken'       => [ 'shape' => 'PageToken', ],
			],
		],
		'ListServiceActionsForProvisioningArtifactInput'               => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'ProvisioningArtifactId',
			],
			'members'  => [
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'PageSize'               => [ 'shape' => 'PageSize', ],
				'PageToken'              => [ 'shape' => 'PageToken', ],
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'ListServiceActionsForProvisioningArtifactOutput'              => [
			'type'    => 'structure',
			'members' => [
				'ServiceActionSummaries' => [ 'shape' => 'ServiceActionSummaries', ],
				'NextPageToken'          => [ 'shape' => 'PageToken', ],
			],
		],
		'ListServiceActionsInput'                                      => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'ListServiceActionsOutput'                                     => [
			'type'    => 'structure',
			'members' => [
				'ServiceActionSummaries' => [ 'shape' => 'ServiceActionSummaries', ],
				'NextPageToken'          => [ 'shape' => 'PageToken', ],
			],
		],
		'ListStackInstancesForProvisionedProductInput'                 => [
			'type'     => 'structure',
			'required' => [ 'ProvisionedProductId', ],
			'members'  => [
				'AcceptLanguage'       => [ 'shape' => 'AcceptLanguage', ],
				'ProvisionedProductId' => [ 'shape' => 'Id', ],
				'PageToken'            => [ 'shape' => 'PageToken', ],
				'PageSize'             => [ 'shape' => 'PageSize', ],
			],
		],
		'ListStackInstancesForProvisionedProductOutput'                => [
			'type'    => 'structure',
			'members' => [
				'StackInstances' => [ 'shape' => 'StackInstances', ],
				'NextPageToken'  => [ 'shape' => 'PageToken', ],
			],
		],
		'ListTagOptionsFilters'                                        => [
			'type'    => 'structure',
			'members' => [
				'Key'    => [ 'shape' => 'TagOptionKey', ],
				'Value'  => [ 'shape' => 'TagOptionValue', ],
				'Active' => [ 'shape' => 'TagOptionActive', ],
			],
		],
		'ListTagOptionsInput'                                          => [
			'type'    => 'structure',
			'members' => [
				'Filters'   => [ 'shape' => 'ListTagOptionsFilters', ],
				'PageSize'  => [ 'shape' => 'PageSize', ],
				'PageToken' => [ 'shape' => 'PageToken', ],
			],
		],
		'ListTagOptionsOutput'                                         => [
			'type'    => 'structure',
			'members' => [
				'TagOptionDetails' => [ 'shape' => 'TagOptionDetails', ],
				'PageToken'        => [ 'shape' => 'PageToken', ],
			],
		],
		'LogicalResourceId'                                            => [ 'type' => 'string', ],
		'Message'                                                      => [ 'type' => 'string', ],
		'Namespaces'                                                   => [
			'type'   => 'list',
			'member' => [ 'shape' => 'AccountId', ],
		],
		'NoEcho'                                                       => [ 'type' => 'boolean', ],
		'NotificationArn'                                              => [
			'type'    => 'string',
			'max'     => 1224,
			'min'     => 1,
			'pattern' => 'arn:[a-z0-9-\\.]{1,63}:[a-z0-9-\\.]{0,63}:[a-z0-9-\\.]{0,63}:[a-z0-9-\\.]{0,63}:[^/].{0,1023}',
		],
		'NotificationArns'                                             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'NotificationArn', ],
			'max'    => 5,
		],
		'OperationNotSupportedException'                               => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'OrganizationNode'                                             => [
			'type'    => 'structure',
			'members' => [
				'Type'  => [ 'shape' => 'OrganizationNodeType', ],
				'Value' => [ 'shape' => 'OrganizationNodeValue', ],
			],
		],
		'OrganizationNodeType'                                         => [
			'type' => 'string',
			'enum' => [
				'ORGANIZATION',
				'ORGANIZATIONAL_UNIT',
				'ACCOUNT',
			],
		],
		'OrganizationNodeValue'                                        => [
			'type'    => 'string',
			'pattern' => '(^[0-9]{12}$)|(^arn:aws:organizations::\\d{12}:organization\\/o-[a-z0-9]{10,32})|(^o-[a-z0-9]{10,32}$)|(^arn:aws:organizations::\\d{12}:ou\\/o-[a-z0-9]{10,32}\\/ou-[0-9a-z]{4,32}-[0-9a-z]{8,32}$)|(^ou-[0-9a-z]{4,32}-[a-z0-9]{8,32}$)',
		],
		'OrganizationNodes'                                            => [
			'type'   => 'list',
			'member' => [ 'shape' => 'OrganizationNode', ],
		],
		'OutputKey'                                                    => [ 'type' => 'string', ],
		'OutputValue'                                                  => [ 'type' => 'string', ],
		'PageSize'                                                     => [
			'type' => 'integer',
			'max'  => 20,
			'min'  => 0,
		],
		'PageToken'                                                    => [
			'type'    => 'string',
			'max'     => 2024,
			'pattern' => '[\\u0009\\u000a\\u000d\\u0020-\\uD7FF\\uE000-\\uFFFD]*',
		],
		'ParameterConstraints'                                         => [
			'type'    => 'structure',
			'members' => [ 'AllowedValues' => [ 'shape' => 'AllowedValues', ], ],
		],
		'ParameterKey'                                                 => [
			'type' => 'string',
			'max'  => 1000,
			'min'  => 1,
		],
		'ParameterType'                                                => [ 'type' => 'string', ],
		'ParameterValue'                                               => [ 'type' => 'string', 'max' => 4096, ],
		'PhysicalId'                                                   => [ 'type' => 'string', ],
		'PhysicalResourceId'                                           => [ 'type' => 'string', ],
		'PlanResourceType'                                             => [
			'type' => 'string',
			'max'  => 256,
			'min'  => 1,
		],
		'PortfolioDescription'                                         => [ 'type' => 'string', 'max' => 2000, ],
		'PortfolioDetail'                                              => [
			'type'    => 'structure',
			'members' => [
				'Id'           => [ 'shape' => 'Id', ],
				'ARN'          => [ 'shape' => 'ResourceARN', ],
				'DisplayName'  => [ 'shape' => 'PortfolioDisplayName', ],
				'Description'  => [ 'shape' => 'PortfolioDescription', ],
				'CreatedTime'  => [ 'shape' => 'CreationTime', ],
				'ProviderName' => [ 'shape' => 'ProviderName', ],
			],
		],
		'PortfolioDetails'                                             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'PortfolioDetail', ],
		],
		'PortfolioDisplayName'                                         => [
			'type' => 'string',
			'max'  => 100,
			'min'  => 1,
		],
		'PortfolioName'                                                => [ 'type' => 'string', ],
		'PortfolioShareType'                                           => [
			'type' => 'string',
			'enum' => [
				'IMPORTED',
				'AWS_SERVICECATALOG',
				'AWS_ORGANIZATIONS',
			],
		],
		'Principal'                                                    => [
			'type'    => 'structure',
			'members' => [
				'PrincipalARN'  => [ 'shape' => 'PrincipalARN', ],
				'PrincipalType' => [ 'shape' => 'PrincipalType', ],
			],
		],
		'PrincipalARN'                                                 => [
			'type' => 'string',
			'max'  => 1000,
			'min'  => 1,
		],
		'PrincipalType'                                                => [ 'type' => 'string', 'enum' => [ 'IAM', ], ],
		'Principals'                                                   => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Principal', ],
		],
		'ProductArn'                                                   => [
			'type'    => 'string',
			'max'     => 1224,
			'min'     => 1,
			'pattern' => 'arn:[a-z0-9-\\.]{1,63}:[a-z0-9-\\.]{0,63}:[a-z0-9-\\.]{0,63}:[a-z0-9-\\.]{0,63}:[^/].{0,1023}',
		],
		'ProductSource'                                                => [
			'type' => 'string',
			'enum' => [ 'ACCOUNT', ],
		],
		'ProductType'                                                  => [
			'type' => 'string',
			'enum' => [
				'CLOUD_FORMATION_TEMPLATE',
				'MARKETPLACE',
			],
			'max'  => 8191,
		],
		'ProductViewAggregationType'                                   => [ 'type' => 'string', ],
		'ProductViewAggregationValue'                                  => [
			'type'    => 'structure',
			'members' => [
				'Value'            => [ 'shape' => 'AttributeValue', ],
				'ApproximateCount' => [ 'shape' => 'ApproximateCount', ],
			],
		],
		'ProductViewAggregationValues'                                 => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProductViewAggregationValue', ],
		],
		'ProductViewAggregations'                                      => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'ProductViewAggregationType', ],
			'value' => [ 'shape' => 'ProductViewAggregationValues', ],
		],
		'ProductViewDetail'                                            => [
			'type'    => 'structure',
			'members' => [
				'ProductViewSummary' => [ 'shape' => 'ProductViewSummary', ],
				'Status'             => [ 'shape' => 'Status', ],
				'ProductARN'         => [ 'shape' => 'ResourceARN', ],
				'CreatedTime'        => [ 'shape' => 'CreatedTime', ],
			],
		],
		'ProductViewDetails'                                           => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProductViewDetail', ],
		],
		'ProductViewDistributor'                                       => [ 'type' => 'string', ],
		'ProductViewFilterBy'                                          => [
			'type' => 'string',
			'enum' => [
				'FullTextSearch',
				'Owner',
				'ProductType',
				'SourceProductId',
			],
		],
		'ProductViewFilterValue'                                       => [ 'type' => 'string', ],
		'ProductViewFilterValues'                                      => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProductViewFilterValue', ],
		],
		'ProductViewFilters'                                           => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'ProductViewFilterBy', ],
			'value' => [ 'shape' => 'ProductViewFilterValues', ],
		],
		'ProductViewName'                                              => [ 'type' => 'string', 'max' => 8191, ],
		'ProductViewOwner'                                             => [ 'type' => 'string', 'max' => 8191, ],
		'ProductViewShortDescription'                                  => [ 'type' => 'string', 'max' => 8191, ],
		'ProductViewSortBy'                                            => [
			'type' => 'string',
			'enum' => [
				'Title',
				'VersionCount',
				'CreationDate',
			],
		],
		'ProductViewSummaries'                                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProductViewSummary', ],
		],
		'ProductViewSummary'                                           => [
			'type'    => 'structure',
			'members' => [
				'Id'                 => [ 'shape' => 'Id', ],
				'ProductId'          => [ 'shape' => 'Id', ],
				'Name'               => [ 'shape' => 'ProductViewName', ],
				'Owner'              => [ 'shape' => 'ProductViewOwner', ],
				'ShortDescription'   => [ 'shape' => 'ProductViewShortDescription', ],
				'Type'               => [ 'shape' => 'ProductType', ],
				'Distributor'        => [ 'shape' => 'ProductViewDistributor', ],
				'HasDefaultPath'     => [ 'shape' => 'HasDefaultPath', ],
				'SupportEmail'       => [ 'shape' => 'SupportEmail', ],
				'SupportDescription' => [ 'shape' => 'SupportDescription', ],
				'SupportUrl'         => [ 'shape' => 'SupportUrl', ],
			],
		],
		'PropertyKey'                                                  => [
			'type' => 'string',
			'enum' => [ 'OWNER', ],
			'max'  => 128,
			'min'  => 1,
		],
		'PropertyName'                                                 => [ 'type' => 'string', ],
		'PropertyValue'                                                => [
			'type' => 'string',
			'max'  => 1024,
			'min'  => 1,
		],
		'ProviderName'                                                 => [
			'type' => 'string',
			'max'  => 50,
			'min'  => 1,
		],
		'ProvisionProductInput'                                        => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'ProvisioningArtifactId',
				'ProvisionedProductName',
				'ProvisionToken',
			],
			'members'  => [
				'AcceptLanguage'          => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'               => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId'  => [ 'shape' => 'Id', ],
				'PathId'                  => [ 'shape' => 'Id', ],
				'ProvisionedProductName'  => [ 'shape' => 'ProvisionedProductName', ],
				'ProvisioningParameters'  => [ 'shape' => 'ProvisioningParameters', ],
				'ProvisioningPreferences' => [ 'shape' => 'ProvisioningPreferences', ],
				'Tags'                    => [ 'shape' => 'Tags', ],
				'NotificationArns'        => [ 'shape' => 'NotificationArns', ],
				'ProvisionToken'          => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'ProvisionProductOutput'                                       => [
			'type'    => 'structure',
			'members' => [ 'RecordDetail' => [ 'shape' => 'RecordDetail', ], ],
		],
		'ProvisionedProductAttribute'                                  => [
			'type'    => 'structure',
			'members' => [
				'Name'                   => [ 'shape' => 'ProvisionedProductNameOrArn', ],
				'Arn'                    => [ 'shape' => 'ProvisionedProductNameOrArn', ],
				'Type'                   => [ 'shape' => 'ProvisionedProductType', ],
				'Id'                     => [ 'shape' => 'Id', ],
				'Status'                 => [ 'shape' => 'ProvisionedProductStatus', ],
				'StatusMessage'          => [ 'shape' => 'ProvisionedProductStatusMessage', ],
				'CreatedTime'            => [ 'shape' => 'CreatedTime', ],
				'IdempotencyToken'       => [ 'shape' => 'IdempotencyToken', ],
				'LastRecordId'           => [ 'shape' => 'Id', ],
				'Tags'                   => [ 'shape' => 'Tags', ],
				'PhysicalId'             => [ 'shape' => 'PhysicalId', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'UserArn'                => [ 'shape' => 'UserArn', ],
				'UserArnSession'         => [ 'shape' => 'UserArnSession', ],
			],
		],
		'ProvisionedProductAttributes'                                 => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisionedProductAttribute', ],
		],
		'ProvisionedProductDetail'                                     => [
			'type'    => 'structure',
			'members' => [
				'Name'                   => [ 'shape' => 'ProvisionedProductNameOrArn', ],
				'Arn'                    => [ 'shape' => 'ProvisionedProductNameOrArn', ],
				'Type'                   => [ 'shape' => 'ProvisionedProductType', ],
				'Id'                     => [ 'shape' => 'ProvisionedProductId', ],
				'Status'                 => [ 'shape' => 'ProvisionedProductStatus', ],
				'StatusMessage'          => [ 'shape' => 'ProvisionedProductStatusMessage', ],
				'CreatedTime'            => [ 'shape' => 'CreatedTime', ],
				'IdempotencyToken'       => [ 'shape' => 'IdempotencyToken', ],
				'LastRecordId'           => [ 'shape' => 'LastRequestId', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
			],
		],
		'ProvisionedProductDetails'                                    => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisionedProductDetail', ],
		],
		'ProvisionedProductFilters'                                    => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'ProvisionedProductViewFilterBy', ],
			'value' => [ 'shape' => 'ProvisionedProductViewFilterValues', ],
		],
		'ProvisionedProductId'                                         => [ 'type' => 'string', ],
		'ProvisionedProductName'                                       => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '[a-zA-Z0-9][a-zA-Z0-9._-]*',
		],
		'ProvisionedProductNameOrArn'                                  => [
			'type'    => 'string',
			'max'     => 1224,
			'min'     => 1,
			'pattern' => '[a-zA-Z0-9][a-zA-Z0-9._-]{0,127}|arn:[a-z0-9-\\.]{1,63}:[a-z0-9-\\.]{0,63}:[a-z0-9-\\.]{0,63}:[a-z0-9-\\.]{0,63}:[^/].{0,1023}',
		],
		'ProvisionedProductPlanDetails'                                => [
			'type'    => 'structure',
			'members' => [
				'CreatedTime'            => [ 'shape' => 'CreatedTime', ],
				'PathId'                 => [ 'shape' => 'Id', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'PlanName'               => [ 'shape' => 'ProvisionedProductPlanName', ],
				'PlanId'                 => [ 'shape' => 'Id', ],
				'ProvisionProductId'     => [ 'shape' => 'Id', ],
				'ProvisionProductName'   => [ 'shape' => 'ProvisionedProductName', ],
				'PlanType'               => [ 'shape' => 'ProvisionedProductPlanType', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'Status'                 => [ 'shape' => 'ProvisionedProductPlanStatus', ],
				'UpdatedTime'            => [ 'shape' => 'UpdatedTime', ],
				'NotificationArns'       => [ 'shape' => 'NotificationArns', ],
				'ProvisioningParameters' => [ 'shape' => 'UpdateProvisioningParameters', ],
				'Tags'                   => [ 'shape' => 'Tags', ],
				'StatusMessage'          => [ 'shape' => 'StatusMessage', ],
			],
		],
		'ProvisionedProductPlanName'                                   => [ 'type' => 'string', ],
		'ProvisionedProductPlanStatus'                                 => [
			'type' => 'string',
			'enum' => [
				'CREATE_IN_PROGRESS',
				'CREATE_SUCCESS',
				'CREATE_FAILED',
				'EXECUTE_IN_PROGRESS',
				'EXECUTE_SUCCESS',
				'EXECUTE_FAILED',
			],
		],
		'ProvisionedProductPlanSummary'                                => [
			'type'    => 'structure',
			'members' => [
				'PlanName'               => [ 'shape' => 'ProvisionedProductPlanName', ],
				'PlanId'                 => [ 'shape' => 'Id', ],
				'ProvisionProductId'     => [ 'shape' => 'Id', ],
				'ProvisionProductName'   => [ 'shape' => 'ProvisionedProductName', ],
				'PlanType'               => [ 'shape' => 'ProvisionedProductPlanType', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
			],
		],
		'ProvisionedProductPlanType'                                   => [
			'type' => 'string',
			'enum' => [ 'CLOUDFORMATION', ],
		],
		'ProvisionedProductPlans'                                      => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisionedProductPlanSummary', ],
		],
		'ProvisionedProductProperties'                                 => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'PropertyKey', ],
			'value' => [ 'shape' => 'PropertyValue', ],
			'max'   => 100,
			'min'   => 1,
		],
		'ProvisionedProductStatus'                                     => [
			'type' => 'string',
			'enum' => [
				'AVAILABLE',
				'UNDER_CHANGE',
				'TAINTED',
				'ERROR',
				'PLAN_IN_PROGRESS',
			],
		],
		'ProvisionedProductStatusMessage'                              => [ 'type' => 'string', ],
		'ProvisionedProductType'                                       => [ 'type' => 'string', ],
		'ProvisionedProductViewFilterBy'                               => [
			'type' => 'string',
			'enum' => [ 'SearchQuery', ],
		],
		'ProvisionedProductViewFilterValue'                            => [ 'type' => 'string', ],
		'ProvisionedProductViewFilterValues'                           => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisionedProductViewFilterValue', ],
		],
		'ProvisioningArtifact'                                         => [
			'type'    => 'structure',
			'members' => [
				'Id'          => [ 'shape' => 'Id', ],
				'Name'        => [ 'shape' => 'ProvisioningArtifactName', ],
				'Description' => [ 'shape' => 'ProvisioningArtifactDescription', ],
				'CreatedTime' => [ 'shape' => 'ProvisioningArtifactCreatedTime', ],
				'Guidance'    => [ 'shape' => 'ProvisioningArtifactGuidance', ],
			],
		],
		'ProvisioningArtifactActive'                                   => [ 'type' => 'boolean', ],
		'ProvisioningArtifactCreatedTime'                              => [ 'type' => 'timestamp', ],
		'ProvisioningArtifactDescription'                              => [ 'type' => 'string', ],
		'ProvisioningArtifactDetail'                                   => [
			'type'    => 'structure',
			'members' => [
				'Id'          => [ 'shape' => 'Id', ],
				'Name'        => [ 'shape' => 'ProvisioningArtifactName', ],
				'Description' => [ 'shape' => 'ProvisioningArtifactName', ],
				'Type'        => [ 'shape' => 'ProvisioningArtifactType', ],
				'CreatedTime' => [ 'shape' => 'CreationTime', ],
				'Active'      => [ 'shape' => 'ProvisioningArtifactActive', ],
				'Guidance'    => [ 'shape' => 'ProvisioningArtifactGuidance', ],
			],
		],
		'ProvisioningArtifactDetails'                                  => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisioningArtifactDetail', ],
		],
		'ProvisioningArtifactGuidance'                                 => [
			'type' => 'string',
			'enum' => [ 'DEFAULT', 'DEPRECATED', ],
		],
		'ProvisioningArtifactInfo'                                     => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'ProvisioningArtifactInfoKey', ],
			'value' => [ 'shape' => 'ProvisioningArtifactInfoValue', ],
			'max'   => 100,
			'min'   => 1,
		],
		'ProvisioningArtifactInfoKey'                                  => [ 'type' => 'string', ],
		'ProvisioningArtifactInfoValue'                                => [ 'type' => 'string', ],
		'ProvisioningArtifactName'                                     => [ 'type' => 'string', ],
		'ProvisioningArtifactParameter'                                => [
			'type'    => 'structure',
			'members' => [
				'ParameterKey'         => [ 'shape' => 'ParameterKey', ],
				'DefaultValue'         => [ 'shape' => 'DefaultValue', ],
				'ParameterType'        => [ 'shape' => 'ParameterType', ],
				'IsNoEcho'             => [ 'shape' => 'NoEcho', ],
				'Description'          => [ 'shape' => 'Description', ],
				'ParameterConstraints' => [ 'shape' => 'ParameterConstraints', ],
			],
		],
		'ProvisioningArtifactParameters'                               => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisioningArtifactParameter', ],
		],
		'ProvisioningArtifactPreferences'                              => [
			'type'    => 'structure',
			'members' => [
				'StackSetAccounts' => [ 'shape' => 'StackSetAccounts', ],
				'StackSetRegions'  => [ 'shape' => 'StackSetRegions', ],
			],
		],
		'ProvisioningArtifactProperties'                               => [
			'type'     => 'structure',
			'required' => [ 'Info', ],
			'members'  => [
				'Name'                      => [ 'shape' => 'ProvisioningArtifactName', ],
				'Description'               => [ 'shape' => 'ProvisioningArtifactDescription', ],
				'Info'                      => [ 'shape' => 'ProvisioningArtifactInfo', ],
				'Type'                      => [ 'shape' => 'ProvisioningArtifactType', ],
				'DisableTemplateValidation' => [ 'shape' => 'DisableTemplateValidation', ],
			],
		],
		'ProvisioningArtifactPropertyName'                             => [ 'type' => 'string', 'enum' => [ 'Id', ], ],
		'ProvisioningArtifactPropertyValue'                            => [ 'type' => 'string', ],
		'ProvisioningArtifactSummaries'                                => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisioningArtifactSummary', ],
		],
		'ProvisioningArtifactSummary'                                  => [
			'type'    => 'structure',
			'members' => [
				'Id'                           => [ 'shape' => 'Id', ],
				'Name'                         => [ 'shape' => 'ProvisioningArtifactName', ],
				'Description'                  => [ 'shape' => 'ProvisioningArtifactDescription', ],
				'CreatedTime'                  => [ 'shape' => 'ProvisioningArtifactCreatedTime', ],
				'ProvisioningArtifactMetadata' => [ 'shape' => 'ProvisioningArtifactInfo', ],
			],
		],
		'ProvisioningArtifactType'                                     => [
			'type' => 'string',
			'enum' => [
				'CLOUD_FORMATION_TEMPLATE',
				'MARKETPLACE_AMI',
				'MARKETPLACE_CAR',
			],
		],
		'ProvisioningArtifactView'                                     => [
			'type'    => 'structure',
			'members' => [
				'ProductViewSummary'   => [ 'shape' => 'ProductViewSummary', ],
				'ProvisioningArtifact' => [ 'shape' => 'ProvisioningArtifact', ],
			],
		],
		'ProvisioningArtifactViews'                                    => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisioningArtifactView', ],
		],
		'ProvisioningArtifacts'                                        => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisioningArtifact', ],
		],
		'ProvisioningParameter'                                        => [
			'type'    => 'structure',
			'members' => [
				'Key'   => [ 'shape' => 'ParameterKey', ],
				'Value' => [ 'shape' => 'ParameterValue', ],
			],
		],
		'ProvisioningParameters'                                       => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ProvisioningParameter', ],
		],
		'ProvisioningPreferences'                                      => [
			'type'    => 'structure',
			'members' => [
				'StackSetAccounts'                   => [ 'shape' => 'StackSetAccounts', ],
				'StackSetRegions'                    => [ 'shape' => 'StackSetRegions', ],
				'StackSetFailureToleranceCount'      => [ 'shape' => 'StackSetFailureToleranceCount', ],
				'StackSetFailureTolerancePercentage' => [ 'shape' => 'StackSetFailureTolerancePercentage', ],
				'StackSetMaxConcurrencyCount'        => [ 'shape' => 'StackSetMaxConcurrencyCount', ],
				'StackSetMaxConcurrencyPercentage'   => [ 'shape' => 'StackSetMaxConcurrencyPercentage', ],
			],
		],
		'RecordDetail'                                                 => [
			'type'    => 'structure',
			'members' => [
				'RecordId'               => [ 'shape' => 'Id', ],
				'ProvisionedProductName' => [ 'shape' => 'ProvisionedProductName', ],
				'Status'                 => [ 'shape' => 'RecordStatus', ],
				'CreatedTime'            => [ 'shape' => 'CreatedTime', ],
				'UpdatedTime'            => [ 'shape' => 'UpdatedTime', ],
				'ProvisionedProductType' => [ 'shape' => 'ProvisionedProductType', ],
				'RecordType'             => [ 'shape' => 'RecordType', ],
				'ProvisionedProductId'   => [ 'shape' => 'Id', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'PathId'                 => [ 'shape' => 'Id', ],
				'RecordErrors'           => [ 'shape' => 'RecordErrors', ],
				'RecordTags'             => [ 'shape' => 'RecordTags', ],
			],
		],
		'RecordDetails'                                                => [
			'type'   => 'list',
			'member' => [ 'shape' => 'RecordDetail', ],
		],
		'RecordError'                                                  => [
			'type'    => 'structure',
			'members' => [
				'Code'        => [ 'shape' => 'ErrorCode', ],
				'Description' => [ 'shape' => 'ErrorDescription', ],
			],
		],
		'RecordErrors'                                                 => [
			'type'   => 'list',
			'member' => [ 'shape' => 'RecordError', ],
		],
		'RecordOutput'                                                 => [
			'type'    => 'structure',
			'members' => [
				'OutputKey'   => [ 'shape' => 'OutputKey', ],
				'OutputValue' => [ 'shape' => 'OutputValue', ],
				'Description' => [ 'shape' => 'Description', ],
			],
		],
		'RecordOutputs'                                                => [
			'type'   => 'list',
			'member' => [ 'shape' => 'RecordOutput', ],
		],
		'RecordStatus'                                                 => [
			'type' => 'string',
			'enum' => [
				'CREATED',
				'IN_PROGRESS',
				'IN_PROGRESS_IN_ERROR',
				'SUCCEEDED',
				'FAILED',
			],
		],
		'RecordTag'                                                    => [
			'type'    => 'structure',
			'members' => [
				'Key'   => [ 'shape' => 'RecordTagKey', ],
				'Value' => [ 'shape' => 'RecordTagValue', ],
			],
		],
		'RecordTagKey'                                                 => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-%@]*)$',
		],
		'RecordTagValue'                                               => [
			'type'    => 'string',
			'max'     => 256,
			'min'     => 1,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-%@]*)$',
		],
		'RecordTags'                                                   => [
			'type'   => 'list',
			'member' => [ 'shape' => 'RecordTag', ],
			'max'    => 50,
		],
		'RecordType'                                                   => [ 'type' => 'string', ],
		'Region'                                                       => [ 'type' => 'string', ],
		'RejectPortfolioShareInput'                                    => [
			'type'     => 'structure',
			'required' => [ 'PortfolioId', ],
			'members'  => [
				'AcceptLanguage'     => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'        => [ 'shape' => 'Id', ],
				'PortfolioShareType' => [ 'shape' => 'PortfolioShareType', ],
			],
		],
		'RejectPortfolioShareOutput'                                   => [ 'type' => 'structure', 'members' => [], ],
		'Replacement'                                                  => [
			'type' => 'string',
			'enum' => [
				'TRUE',
				'FALSE',
				'CONDITIONAL',
			],
		],
		'RequiresRecreation'                                           => [
			'type' => 'string',
			'enum' => [
				'NEVER',
				'CONDITIONALLY',
				'ALWAYS',
			],
		],
		'ResourceARN'                                                  => [
			'type' => 'string',
			'max'  => 150,
			'min'  => 1,
		],
		'ResourceAttribute'                                            => [
			'type' => 'string',
			'enum' => [
				'PROPERTIES',
				'METADATA',
				'CREATIONPOLICY',
				'UPDATEPOLICY',
				'DELETIONPOLICY',
				'TAGS',
			],
		],
		'ResourceChange'                                               => [
			'type'    => 'structure',
			'members' => [
				'Action'             => [ 'shape' => 'ChangeAction', ],
				'LogicalResourceId'  => [ 'shape' => 'LogicalResourceId', ],
				'PhysicalResourceId' => [ 'shape' => 'PhysicalResourceId', ],
				'ResourceType'       => [ 'shape' => 'PlanResourceType', ],
				'Replacement'        => [ 'shape' => 'Replacement', ],
				'Scope'              => [ 'shape' => 'Scope', ],
				'Details'            => [ 'shape' => 'ResourceChangeDetails', ],
			],
		],
		'ResourceChangeDetail'                                         => [
			'type'    => 'structure',
			'members' => [
				'Target'        => [ 'shape' => 'ResourceTargetDefinition', ],
				'Evaluation'    => [ 'shape' => 'EvaluationType', ],
				'CausingEntity' => [ 'shape' => 'CausingEntity', ],
			],
		],
		'ResourceChangeDetails'                                        => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ResourceChangeDetail', ],
		],
		'ResourceChanges'                                              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ResourceChange', ],
		],
		'ResourceDetail'                                               => [
			'type'    => 'structure',
			'members' => [
				'Id'          => [ 'shape' => 'ResourceDetailId', ],
				'ARN'         => [ 'shape' => 'ResourceDetailARN', ],
				'Name'        => [ 'shape' => 'ResourceDetailName', ],
				'Description' => [ 'shape' => 'ResourceDetailDescription', ],
				'CreatedTime' => [ 'shape' => 'ResourceDetailCreatedTime', ],
			],
		],
		'ResourceDetailARN'                                            => [ 'type' => 'string', ],
		'ResourceDetailCreatedTime'                                    => [ 'type' => 'timestamp', ],
		'ResourceDetailDescription'                                    => [ 'type' => 'string', ],
		'ResourceDetailId'                                             => [ 'type' => 'string', ],
		'ResourceDetailName'                                           => [ 'type' => 'string', ],
		'ResourceDetails'                                              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ResourceDetail', ],
		],
		'ResourceId'                                                   => [ 'type' => 'string', ],
		'ResourceInUseException'                                       => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'ResourceNotFoundException'                                    => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'ResourceTargetDefinition'                                     => [
			'type'    => 'structure',
			'members' => [
				'Attribute'          => [ 'shape' => 'ResourceAttribute', ],
				'Name'               => [ 'shape' => 'PropertyName', ],
				'RequiresRecreation' => [ 'shape' => 'RequiresRecreation', ],
			],
		],
		'ResourceType'                                                 => [ 'type' => 'string', ],
		'ScanProvisionedProductsInput'                                 => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage'    => [ 'shape' => 'AcceptLanguage', ],
				'AccessLevelFilter' => [ 'shape' => 'AccessLevelFilter', ],
				'PageSize'          => [ 'shape' => 'PageSize', ],
				'PageToken'         => [ 'shape' => 'PageToken', ],
			],
		],
		'ScanProvisionedProductsOutput'                                => [
			'type'    => 'structure',
			'members' => [
				'ProvisionedProducts' => [ 'shape' => 'ProvisionedProductDetails', ],
				'NextPageToken'       => [ 'shape' => 'PageToken', ],
			],
		],
		'Scope'                                                        => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ResourceAttribute', ],
		],
		'SearchFilterKey'                                              => [ 'type' => 'string', ],
		'SearchFilterValue'                                            => [ 'type' => 'string', ],
		'SearchProductsAsAdminInput'                                   => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'PortfolioId'    => [ 'shape' => 'Id', ],
				'Filters'        => [ 'shape' => 'ProductViewFilters', ],
				'SortBy'         => [ 'shape' => 'ProductViewSortBy', ],
				'SortOrder'      => [ 'shape' => 'SortOrder', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'ProductSource'  => [ 'shape' => 'ProductSource', ],
			],
		],
		'SearchProductsAsAdminOutput'                                  => [
			'type'    => 'structure',
			'members' => [
				'ProductViewDetails' => [ 'shape' => 'ProductViewDetails', ],
				'NextPageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'SearchProductsInput'                                          => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Filters'        => [ 'shape' => 'ProductViewFilters', ],
				'PageSize'       => [ 'shape' => 'PageSize', ],
				'SortBy'         => [ 'shape' => 'ProductViewSortBy', ],
				'SortOrder'      => [ 'shape' => 'SortOrder', ],
				'PageToken'      => [ 'shape' => 'PageToken', ],
			],
		],
		'SearchProductsOutput'                                         => [
			'type'    => 'structure',
			'members' => [
				'ProductViewSummaries'    => [ 'shape' => 'ProductViewSummaries', ],
				'ProductViewAggregations' => [ 'shape' => 'ProductViewAggregations', ],
				'NextPageToken'           => [ 'shape' => 'PageToken', ],
			],
		],
		'SearchProvisionedProductsInput'                               => [
			'type'    => 'structure',
			'members' => [
				'AcceptLanguage'    => [ 'shape' => 'AcceptLanguage', ],
				'AccessLevelFilter' => [ 'shape' => 'AccessLevelFilter', ],
				'Filters'           => [ 'shape' => 'ProvisionedProductFilters', ],
				'SortBy'            => [ 'shape' => 'SortField', ],
				'SortOrder'         => [ 'shape' => 'SortOrder', ],
				'PageSize'          => [ 'shape' => 'SearchProvisionedProductsPageSize', ],
				'PageToken'         => [ 'shape' => 'PageToken', ],
			],
		],
		'SearchProvisionedProductsOutput'                              => [
			'type'    => 'structure',
			'members' => [
				'ProvisionedProducts' => [ 'shape' => 'ProvisionedProductAttributes', ],
				'TotalResultsCount'   => [ 'shape' => 'TotalResultsCount', ],
				'NextPageToken'       => [ 'shape' => 'PageToken', ],
			],
		],
		'SearchProvisionedProductsPageSize'                            => [
			'type' => 'integer',
			'max'  => 100,
			'min'  => 0,
		],
		'ServiceActionAssociation'                                     => [
			'type'     => 'structure',
			'required' => [
				'ServiceActionId',
				'ProductId',
				'ProvisioningArtifactId',
			],
			'members'  => [
				'ServiceActionId'        => [ 'shape' => 'Id', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
			],
		],
		'ServiceActionAssociationErrorCode'                            => [
			'type' => 'string',
			'enum' => [
				'DUPLICATE_RESOURCE',
				'INTERNAL_FAILURE',
				'LIMIT_EXCEEDED',
				'RESOURCE_NOT_FOUND',
				'THROTTLING',
			],
		],
		'ServiceActionAssociationErrorMessage'                         => [
			'type' => 'string',
			'max'  => 1024,
			'min'  => 1,
		],
		'ServiceActionAssociations'                                    => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ServiceActionAssociation', ],
			'max'    => 50,
			'min'    => 1,
		],
		'ServiceActionDefinitionKey'                                   => [
			'type' => 'string',
			'enum' => [
				'Name',
				'Version',
				'AssumeRole',
				'Parameters',
			],
		],
		'ServiceActionDefinitionMap'                                   => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'ServiceActionDefinitionKey', ],
			'value' => [ 'shape' => 'ServiceActionDefinitionValue', ],
			'max'   => 100,
			'min'   => 1,
		],
		'ServiceActionDefinitionType'                                  => [
			'type' => 'string',
			'enum' => [ 'SSM_AUTOMATION', ],
		],
		'ServiceActionDefinitionValue'                                 => [
			'type' => 'string',
			'max'  => 1024,
			'min'  => 1,
		],
		'ServiceActionDescription'                                     => [ 'type' => 'string', 'max' => 1024, ],
		'ServiceActionDetail'                                          => [
			'type'    => 'structure',
			'members' => [
				'ServiceActionSummary' => [ 'shape' => 'ServiceActionSummary', ],
				'Definition'           => [ 'shape' => 'ServiceActionDefinitionMap', ],
			],
		],
		'ServiceActionName'                                            => [
			'type'    => 'string',
			'max'     => 256,
			'min'     => 1,
			'pattern' => '^[a-zA-Z0-9_\\-.]*',
		],
		'ServiceActionSummaries'                                       => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ServiceActionSummary', ],
		],
		'ServiceActionSummary'                                         => [
			'type'    => 'structure',
			'members' => [
				'Id'             => [ 'shape' => 'Id', ],
				'Name'           => [ 'shape' => 'ServiceActionName', ],
				'Description'    => [ 'shape' => 'ServiceActionDescription', ],
				'DefinitionType' => [ 'shape' => 'ServiceActionDefinitionType', ],
			],
		],
		'ShareDetails'                                                 => [
			'type'    => 'structure',
			'members' => [
				'SuccessfulShares' => [ 'shape' => 'SuccessfulShares', ],
				'ShareErrors'      => [ 'shape' => 'ShareErrors', ],
			],
		],
		'ShareError'                                                   => [
			'type'    => 'structure',
			'members' => [
				'Accounts' => [ 'shape' => 'Namespaces', ],
				'Message'  => [ 'shape' => 'Message', ],
				'Error'    => [ 'shape' => 'Error', ],
			],
		],
		'ShareErrors'                                                  => [
			'type'   => 'list',
			'member' => [ 'shape' => 'ShareError', ],
		],
		'ShareStatus'                                                  => [
			'type' => 'string',
			'enum' => [
				'NOT_STARTED',
				'IN_PROGRESS',
				'COMPLETED',
				'COMPLETED_WITH_ERRORS',
				'ERROR',
			],
		],
		'SortField'                                                    => [ 'type' => 'string', ],
		'SortOrder'                                                    => [
			'type' => 'string',
			'enum' => [ 'ASCENDING', 'DESCENDING', ],
		],
		'SourceProvisioningArtifactProperties'                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'SourceProvisioningArtifactPropertiesMap', ],
		],
		'SourceProvisioningArtifactPropertiesMap'                      => [
			'type'  => 'map',
			'key'   => [ 'shape' => 'ProvisioningArtifactPropertyName', ],
			'value' => [ 'shape' => 'ProvisioningArtifactPropertyValue', ],
		],
		'StackInstance'                                                => [
			'type'    => 'structure',
			'members' => [
				'Account'             => [ 'shape' => 'AccountId', ],
				'Region'              => [ 'shape' => 'Region', ],
				'StackInstanceStatus' => [ 'shape' => 'StackInstanceStatus', ],
			],
		],
		'StackInstanceStatus'                                          => [
			'type' => 'string',
			'enum' => [
				'CURRENT',
				'OUTDATED',
				'INOPERABLE',
			],
		],
		'StackInstances'                                               => [
			'type'   => 'list',
			'member' => [ 'shape' => 'StackInstance', ],
		],
		'StackSetAccounts'                                             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'AccountId', ],
		],
		'StackSetFailureToleranceCount'                                => [ 'type' => 'integer', 'min' => 0, ],
		'StackSetFailureTolerancePercentage'                           => [
			'type' => 'integer',
			'max'  => 100,
			'min'  => 0,
		],
		'StackSetMaxConcurrencyCount'                                  => [ 'type' => 'integer', 'min' => 1, ],
		'StackSetMaxConcurrencyPercentage'                             => [
			'type' => 'integer',
			'max'  => 100,
			'min'  => 1,
		],
		'StackSetOperationType'                                        => [
			'type' => 'string',
			'enum' => [ 'CREATE', 'UPDATE', 'DELETE', ],
		],
		'StackSetRegions'                                              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Region', ],
		],
		'Status'                                                       => [
			'type' => 'string',
			'enum' => [
				'AVAILABLE',
				'CREATING',
				'FAILED',
			],
		],
		'StatusDetail'                                                 => [ 'type' => 'string', ],
		'StatusMessage'                                                => [
			'type'    => 'string',
			'pattern' => '[\\u0009\\u000a\\u000d\\u0020-\\uD7FF\\uE000-\\uFFFD]*',
		],
		'SuccessfulShares'                                             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'AccountId', ],
		],
		'SupportDescription'                                           => [ 'type' => 'string', 'max' => 8191, ],
		'SupportEmail'                                                 => [ 'type' => 'string', 'max' => 254, ],
		'SupportUrl'                                                   => [ 'type' => 'string', 'max' => 2083, ],
		'Tag'                                                          => [
			'type'     => 'structure',
			'required' => [ 'Key', 'Value', ],
			'members'  => [
				'Key'   => [ 'shape' => 'TagKey', ],
				'Value' => [ 'shape' => 'TagValue', ],
			],
		],
		'TagKey'                                                       => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$',
		],
		'TagKeys'                                                      => [
			'type'   => 'list',
			'member' => [ 'shape' => 'TagKey', ],
		],
		'TagOptionActive'                                              => [ 'type' => 'boolean', ],
		'TagOptionDetail'                                              => [
			'type'    => 'structure',
			'members' => [
				'Key'    => [ 'shape' => 'TagOptionKey', ],
				'Value'  => [ 'shape' => 'TagOptionValue', ],
				'Active' => [ 'shape' => 'TagOptionActive', ],
				'Id'     => [ 'shape' => 'TagOptionId', ],
			],
		],
		'TagOptionDetails'                                             => [
			'type'   => 'list',
			'member' => [ 'shape' => 'TagOptionDetail', ],
		],
		'TagOptionId'                                                  => [
			'type' => 'string',
			'max'  => 100,
			'min'  => 1,
		],
		'TagOptionKey'                                                 => [
			'type'    => 'string',
			'max'     => 128,
			'min'     => 1,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$',
		],
		'TagOptionNotMigratedException'                                => [
			'type'      => 'structure',
			'members'   => [],
			'exception' => true,
		],
		'TagOptionSummaries'                                           => [
			'type'   => 'list',
			'member' => [ 'shape' => 'TagOptionSummary', ],
		],
		'TagOptionSummary'                                             => [
			'type'    => 'structure',
			'members' => [
				'Key'    => [ 'shape' => 'TagOptionKey', ],
				'Values' => [ 'shape' => 'TagOptionValues', ],
			],
		],
		'TagOptionValue'                                               => [
			'type'    => 'string',
			'max'     => 256,
			'min'     => 1,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$',
		],
		'TagOptionValues'                                              => [
			'type'   => 'list',
			'member' => [ 'shape' => 'TagOptionValue', ],
		],
		'TagValue'                                                     => [
			'type'    => 'string',
			'max'     => 256,
			'min'     => 1,
			'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$',
		],
		'Tags'                                                         => [
			'type'   => 'list',
			'member' => [ 'shape' => 'Tag', ],
			'max'    => 50,
		],
		'TerminateProvisionedProductInput'                             => [
			'type'     => 'structure',
			'required' => [ 'TerminateToken', ],
			'members'  => [
				'ProvisionedProductName' => [ 'shape' => 'ProvisionedProductNameOrArn', ],
				'ProvisionedProductId'   => [ 'shape' => 'Id', ],
				'TerminateToken'         => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
				'IgnoreErrors'           => [ 'shape' => 'IgnoreErrors', ],
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'TerminateProvisionedProductOutput'                            => [
			'type'    => 'structure',
			'members' => [ 'RecordDetail' => [ 'shape' => 'RecordDetail', ], ],
		],
		'TotalResultsCount'                                            => [ 'type' => 'integer', ],
		'UpdateConstraintInput'                                        => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
				'Description'    => [ 'shape' => 'ConstraintDescription', ],
				'Parameters'     => [ 'shape' => 'ConstraintParameters', ],
			],
		],
		'UpdateConstraintOutput'                                       => [
			'type'    => 'structure',
			'members' => [
				'ConstraintDetail'     => [ 'shape' => 'ConstraintDetail', ],
				'ConstraintParameters' => [ 'shape' => 'ConstraintParameters', ],
				'Status'               => [ 'shape' => 'Status', ],
			],
		],
		'UpdatePortfolioInput'                                         => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
				'Id'             => [ 'shape' => 'Id', ],
				'DisplayName'    => [ 'shape' => 'PortfolioDisplayName', ],
				'Description'    => [ 'shape' => 'PortfolioDescription', ],
				'ProviderName'   => [ 'shape' => 'ProviderName', ],
				'AddTags'        => [ 'shape' => 'AddTags', ],
				'RemoveTags'     => [ 'shape' => 'TagKeys', ],
			],
		],
		'UpdatePortfolioOutput'                                        => [
			'type'    => 'structure',
			'members' => [
				'PortfolioDetail' => [ 'shape' => 'PortfolioDetail', ],
				'Tags'            => [ 'shape' => 'Tags', ],
			],
		],
		'UpdateProductInput'                                           => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'AcceptLanguage'     => [ 'shape' => 'AcceptLanguage', ],
				'Id'                 => [ 'shape' => 'Id', ],
				'Name'               => [ 'shape' => 'ProductViewName', ],
				'Owner'              => [ 'shape' => 'ProductViewOwner', ],
				'Description'        => [ 'shape' => 'ProductViewShortDescription', ],
				'Distributor'        => [ 'shape' => 'ProductViewOwner', ],
				'SupportDescription' => [ 'shape' => 'SupportDescription', ],
				'SupportEmail'       => [ 'shape' => 'SupportEmail', ],
				'SupportUrl'         => [ 'shape' => 'SupportUrl', ],
				'AddTags'            => [ 'shape' => 'AddTags', ],
				'RemoveTags'         => [ 'shape' => 'TagKeys', ],
			],
		],
		'UpdateProductOutput'                                          => [
			'type'    => 'structure',
			'members' => [
				'ProductViewDetail' => [ 'shape' => 'ProductViewDetail', ],
				'Tags'              => [ 'shape' => 'Tags', ],
			],
		],
		'UpdateProvisionedProductInput'                                => [
			'type'     => 'structure',
			'required' => [ 'UpdateToken', ],
			'members'  => [
				'AcceptLanguage'          => [ 'shape' => 'AcceptLanguage', ],
				'ProvisionedProductName'  => [ 'shape' => 'ProvisionedProductNameOrArn', ],
				'ProvisionedProductId'    => [ 'shape' => 'Id', ],
				'ProductId'               => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId'  => [ 'shape' => 'Id', ],
				'PathId'                  => [ 'shape' => 'Id', ],
				'ProvisioningParameters'  => [ 'shape' => 'UpdateProvisioningParameters', ],
				'ProvisioningPreferences' => [ 'shape' => 'UpdateProvisioningPreferences', ],
				'Tags'                    => [ 'shape' => 'Tags', ],
				'UpdateToken'             => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'UpdateProvisionedProductOutput'                               => [
			'type'    => 'structure',
			'members' => [ 'RecordDetail' => [ 'shape' => 'RecordDetail', ], ],
		],
		'UpdateProvisionedProductPropertiesInput'                      => [
			'type'     => 'structure',
			'required' => [
				'ProvisionedProductId',
				'ProvisionedProductProperties',
				'IdempotencyToken',
			],
			'members'  => [
				'AcceptLanguage'               => [ 'shape' => 'AcceptLanguage', ],
				'ProvisionedProductId'         => [ 'shape' => 'Id', ],
				'ProvisionedProductProperties' => [ 'shape' => 'ProvisionedProductProperties', ],
				'IdempotencyToken'             => [
					'shape'            => 'IdempotencyToken',
					'idempotencyToken' => true,
				],
			],
		],
		'UpdateProvisionedProductPropertiesOutput'                     => [
			'type'    => 'structure',
			'members' => [
				'ProvisionedProductId'         => [ 'shape' => 'Id', ],
				'ProvisionedProductProperties' => [ 'shape' => 'ProvisionedProductProperties', ],
				'RecordId'                     => [ 'shape' => 'Id', ],
				'Status'                       => [ 'shape' => 'RecordStatus', ],
			],
		],
		'UpdateProvisioningArtifactInput'                              => [
			'type'     => 'structure',
			'required' => [
				'ProductId',
				'ProvisioningArtifactId',
			],
			'members'  => [
				'AcceptLanguage'         => [ 'shape' => 'AcceptLanguage', ],
				'ProductId'              => [ 'shape' => 'Id', ],
				'ProvisioningArtifactId' => [ 'shape' => 'Id', ],
				'Name'                   => [ 'shape' => 'ProvisioningArtifactName', ],
				'Description'            => [ 'shape' => 'ProvisioningArtifactDescription', ],
				'Active'                 => [ 'shape' => 'ProvisioningArtifactActive', ],
				'Guidance'               => [ 'shape' => 'ProvisioningArtifactGuidance', ],
			],
		],
		'UpdateProvisioningArtifactOutput'                             => [
			'type'    => 'structure',
			'members' => [
				'ProvisioningArtifactDetail' => [ 'shape' => 'ProvisioningArtifactDetail', ],
				'Info'                       => [ 'shape' => 'ProvisioningArtifactInfo', ],
				'Status'                     => [ 'shape' => 'Status', ],
			],
		],
		'UpdateProvisioningParameter'                                  => [
			'type'    => 'structure',
			'members' => [
				'Key'              => [ 'shape' => 'ParameterKey', ],
				'Value'            => [ 'shape' => 'ParameterValue', ],
				'UsePreviousValue' => [ 'shape' => 'UsePreviousValue', ],
			],
		],
		'UpdateProvisioningParameters'                                 => [
			'type'   => 'list',
			'member' => [ 'shape' => 'UpdateProvisioningParameter', ],
		],
		'UpdateProvisioningPreferences'                                => [
			'type'    => 'structure',
			'members' => [
				'StackSetAccounts'                   => [ 'shape' => 'StackSetAccounts', ],
				'StackSetRegions'                    => [ 'shape' => 'StackSetRegions', ],
				'StackSetFailureToleranceCount'      => [ 'shape' => 'StackSetFailureToleranceCount', ],
				'StackSetFailureTolerancePercentage' => [ 'shape' => 'StackSetFailureTolerancePercentage', ],
				'StackSetMaxConcurrencyCount'        => [ 'shape' => 'StackSetMaxConcurrencyCount', ],
				'StackSetMaxConcurrencyPercentage'   => [ 'shape' => 'StackSetMaxConcurrencyPercentage', ],
				'StackSetOperationType'              => [ 'shape' => 'StackSetOperationType', ],
			],
		],
		'UpdateServiceActionInput'                                     => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'Id'             => [ 'shape' => 'Id', ],
				'Name'           => [ 'shape' => 'ServiceActionName', ],
				'Definition'     => [ 'shape' => 'ServiceActionDefinitionMap', ],
				'Description'    => [ 'shape' => 'ServiceActionDescription', ],
				'AcceptLanguage' => [ 'shape' => 'AcceptLanguage', ],
			],
		],
		'UpdateServiceActionOutput'                                    => [
			'type'    => 'structure',
			'members' => [ 'ServiceActionDetail' => [ 'shape' => 'ServiceActionDetail', ], ],
		],
		'UpdateTagOptionInput'                                         => [
			'type'     => 'structure',
			'required' => [ 'Id', ],
			'members'  => [
				'Id'     => [ 'shape' => 'TagOptionId', ],
				'Value'  => [ 'shape' => 'TagOptionValue', ],
				'Active' => [ 'shape' => 'TagOptionActive', ],
			],
		],
		'UpdateTagOptionOutput'                                        => [
			'type'    => 'structure',
			'members' => [ 'TagOptionDetail' => [ 'shape' => 'TagOptionDetail', ], ],
		],
		'UpdatedTime'                                                  => [ 'type' => 'timestamp', ],
		'UsageInstruction'                                             => [
			'type'    => 'structure',
			'members' => [
				'Type'  => [ 'shape' => 'InstructionType', ],
				'Value' => [ 'shape' => 'InstructionValue', ],
			],
		],
		'UsageInstructions'                                            => [
			'type'   => 'list',
			'member' => [ 'shape' => 'UsageInstruction', ],
		],
		'UsePreviousValue'                                             => [ 'type' => 'boolean', ],
		'UserArn'                                                      => [ 'type' => 'string', ],
		'UserArnSession'                                               => [ 'type' => 'string', ],
		'Verbose'                                                      => [ 'type' => 'boolean', ],
	],
];
