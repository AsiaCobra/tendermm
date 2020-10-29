<?php

namespace Aws\ApplicationDiscoveryService;

use Aws\AwsClient;
use Aws\Result;
use GuzzleHttp\Promise\Promise;

/**
 * This client is used to interact with the **AWS Application Discovery Service** service.
 * @method Result associateConfigurationItemsToApplication( array $args = [] )
 * @method Promise associateConfigurationItemsToApplicationAsync( array $args = [] )
 * @method Result batchDeleteImportData( array $args = [] )
 * @method Promise batchDeleteImportDataAsync( array $args = [] )
 * @method Result createApplication( array $args = [] )
 * @method Promise createApplicationAsync( array $args = [] )
 * @method Result createTags( array $args = [] )
 * @method Promise createTagsAsync( array $args = [] )
 * @method Result deleteApplications( array $args = [] )
 * @method Promise deleteApplicationsAsync( array $args = [] )
 * @method Result deleteTags( array $args = [] )
 * @method Promise deleteTagsAsync( array $args = [] )
 * @method Result describeAgents( array $args = [] )
 * @method Promise describeAgentsAsync( array $args = [] )
 * @method Result describeConfigurations( array $args = [] )
 * @method Promise describeConfigurationsAsync( array $args = [] )
 * @method Result describeContinuousExports( array $args = [] )
 * @method Promise describeContinuousExportsAsync( array $args = [] )
 * @method Result describeExportConfigurations( array $args = [] )
 * @method Promise describeExportConfigurationsAsync( array $args = [] )
 * @method Result describeExportTasks( array $args = [] )
 * @method Promise describeExportTasksAsync( array $args = [] )
 * @method Result describeImportTasks( array $args = [] )
 * @method Promise describeImportTasksAsync( array $args = [] )
 * @method Result describeTags( array $args = [] )
 * @method Promise describeTagsAsync( array $args = [] )
 * @method Result disassociateConfigurationItemsFromApplication( array $args = [] )
 * @method Promise disassociateConfigurationItemsFromApplicationAsync( array $args = [] )
 * @method Result exportConfigurations( array $args = [] )
 * @method Promise exportConfigurationsAsync( array $args = [] )
 * @method Result getDiscoverySummary( array $args = [] )
 * @method Promise getDiscoverySummaryAsync( array $args = [] )
 * @method Result listConfigurations( array $args = [] )
 * @method Promise listConfigurationsAsync( array $args = [] )
 * @method Result listServerNeighbors( array $args = [] )
 * @method Promise listServerNeighborsAsync( array $args = [] )
 * @method Result startContinuousExport( array $args = [] )
 * @method Promise startContinuousExportAsync( array $args = [] )
 * @method Result startDataCollectionByAgentIds( array $args = [] )
 * @method Promise startDataCollectionByAgentIdsAsync( array $args = [] )
 * @method Result startExportTask( array $args = [] )
 * @method Promise startExportTaskAsync( array $args = [] )
 * @method Result startImportTask( array $args = [] )
 * @method Promise startImportTaskAsync( array $args = [] )
 * @method Result stopContinuousExport( array $args = [] )
 * @method Promise stopContinuousExportAsync( array $args = [] )
 * @method Result stopDataCollectionByAgentIds( array $args = [] )
 * @method Promise stopDataCollectionByAgentIdsAsync( array $args = [] )
 * @method Result updateApplication( array $args = [] )
 * @method Promise updateApplicationAsync( array $args = [] )
 */
class ApplicationDiscoveryServiceClient extends AwsClient {
}
