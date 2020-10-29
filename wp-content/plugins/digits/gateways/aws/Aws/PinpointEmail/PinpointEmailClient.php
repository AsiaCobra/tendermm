<?php

namespace Aws\PinpointEmail;

use Aws\AwsClient;
use Aws\Result;
use GuzzleHttp\Promise\Promise;

/**
 * This client is used to interact with the **Amazon Pinpoint Email Service** service.
 * @method Result createConfigurationSet( array $args = [] )
 * @method Promise createConfigurationSetAsync( array $args = [] )
 * @method Result createConfigurationSetEventDestination( array $args = [] )
 * @method Promise createConfigurationSetEventDestinationAsync( array $args = [] )
 * @method Result createDedicatedIpPool( array $args = [] )
 * @method Promise createDedicatedIpPoolAsync( array $args = [] )
 * @method Result createDeliverabilityTestReport( array $args = [] )
 * @method Promise createDeliverabilityTestReportAsync( array $args = [] )
 * @method Result createEmailIdentity( array $args = [] )
 * @method Promise createEmailIdentityAsync( array $args = [] )
 * @method Result deleteConfigurationSet( array $args = [] )
 * @method Promise deleteConfigurationSetAsync( array $args = [] )
 * @method Result deleteConfigurationSetEventDestination( array $args = [] )
 * @method Promise deleteConfigurationSetEventDestinationAsync( array $args = [] )
 * @method Result deleteDedicatedIpPool( array $args = [] )
 * @method Promise deleteDedicatedIpPoolAsync( array $args = [] )
 * @method Result deleteEmailIdentity( array $args = [] )
 * @method Promise deleteEmailIdentityAsync( array $args = [] )
 * @method Result getAccount( array $args = [] )
 * @method Promise getAccountAsync( array $args = [] )
 * @method Result getBlacklistReports( array $args = [] )
 * @method Promise getBlacklistReportsAsync( array $args = [] )
 * @method Result getConfigurationSet( array $args = [] )
 * @method Promise getConfigurationSetAsync( array $args = [] )
 * @method Result getConfigurationSetEventDestinations( array $args = [] )
 * @method Promise getConfigurationSetEventDestinationsAsync( array $args = [] )
 * @method Result getDedicatedIp( array $args = [] )
 * @method Promise getDedicatedIpAsync( array $args = [] )
 * @method Result getDedicatedIps( array $args = [] )
 * @method Promise getDedicatedIpsAsync( array $args = [] )
 * @method Result getDeliverabilityDashboardOptions( array $args = [] )
 * @method Promise getDeliverabilityDashboardOptionsAsync( array $args = [] )
 * @method Result getDeliverabilityTestReport( array $args = [] )
 * @method Promise getDeliverabilityTestReportAsync( array $args = [] )
 * @method Result getDomainDeliverabilityCampaign( array $args = [] )
 * @method Promise getDomainDeliverabilityCampaignAsync( array $args = [] )
 * @method Result getDomainStatisticsReport( array $args = [] )
 * @method Promise getDomainStatisticsReportAsync( array $args = [] )
 * @method Result getEmailIdentity( array $args = [] )
 * @method Promise getEmailIdentityAsync( array $args = [] )
 * @method Result listConfigurationSets( array $args = [] )
 * @method Promise listConfigurationSetsAsync( array $args = [] )
 * @method Result listDedicatedIpPools( array $args = [] )
 * @method Promise listDedicatedIpPoolsAsync( array $args = [] )
 * @method Result listDeliverabilityTestReports( array $args = [] )
 * @method Promise listDeliverabilityTestReportsAsync( array $args = [] )
 * @method Result listDomainDeliverabilityCampaigns( array $args = [] )
 * @method Promise listDomainDeliverabilityCampaignsAsync( array $args = [] )
 * @method Result listEmailIdentities( array $args = [] )
 * @method Promise listEmailIdentitiesAsync( array $args = [] )
 * @method Result listTagsForResource( array $args = [] )
 * @method Promise listTagsForResourceAsync( array $args = [] )
 * @method Result putAccountDedicatedIpWarmupAttributes( array $args = [] )
 * @method Promise putAccountDedicatedIpWarmupAttributesAsync( array $args = [] )
 * @method Result putAccountSendingAttributes( array $args = [] )
 * @method Promise putAccountSendingAttributesAsync( array $args = [] )
 * @method Result putConfigurationSetDeliveryOptions( array $args = [] )
 * @method Promise putConfigurationSetDeliveryOptionsAsync( array $args = [] )
 * @method Result putConfigurationSetReputationOptions( array $args = [] )
 * @method Promise putConfigurationSetReputationOptionsAsync( array $args = [] )
 * @method Result putConfigurationSetSendingOptions( array $args = [] )
 * @method Promise putConfigurationSetSendingOptionsAsync( array $args = [] )
 * @method Result putConfigurationSetTrackingOptions( array $args = [] )
 * @method Promise putConfigurationSetTrackingOptionsAsync( array $args = [] )
 * @method Result putDedicatedIpInPool( array $args = [] )
 * @method Promise putDedicatedIpInPoolAsync( array $args = [] )
 * @method Result putDedicatedIpWarmupAttributes( array $args = [] )
 * @method Promise putDedicatedIpWarmupAttributesAsync( array $args = [] )
 * @method Result putDeliverabilityDashboardOption( array $args = [] )
 * @method Promise putDeliverabilityDashboardOptionAsync( array $args = [] )
 * @method Result putEmailIdentityDkimAttributes( array $args = [] )
 * @method Promise putEmailIdentityDkimAttributesAsync( array $args = [] )
 * @method Result putEmailIdentityFeedbackAttributes( array $args = [] )
 * @method Promise putEmailIdentityFeedbackAttributesAsync( array $args = [] )
 * @method Result putEmailIdentityMailFromAttributes( array $args = [] )
 * @method Promise putEmailIdentityMailFromAttributesAsync( array $args = [] )
 * @method Result sendEmail( array $args = [] )
 * @method Promise sendEmailAsync( array $args = [] )
 * @method Result tagResource( array $args = [] )
 * @method Promise tagResourceAsync( array $args = [] )
 * @method Result untagResource( array $args = [] )
 * @method Promise untagResourceAsync( array $args = [] )
 * @method Result updateConfigurationSetEventDestination( array $args = [] )
 * @method Promise updateConfigurationSetEventDestinationAsync( array $args = [] )
 */
class PinpointEmailClient extends AwsClient {
}
