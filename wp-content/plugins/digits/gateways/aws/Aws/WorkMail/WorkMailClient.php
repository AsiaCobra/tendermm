<?php

namespace Aws\WorkMail;

use Aws\AwsClient;
use Aws\Result;
use GuzzleHttp\Promise\Promise;

/**
 * This client is used to interact with the **Amazon WorkMail** service.
 * @method Result associateDelegateToResource( array $args = [] )
 * @method Promise associateDelegateToResourceAsync( array $args = [] )
 * @method Result associateMemberToGroup( array $args = [] )
 * @method Promise associateMemberToGroupAsync( array $args = [] )
 * @method Result createAlias( array $args = [] )
 * @method Promise createAliasAsync( array $args = [] )
 * @method Result createGroup( array $args = [] )
 * @method Promise createGroupAsync( array $args = [] )
 * @method Result createResource( array $args = [] )
 * @method Promise createResourceAsync( array $args = [] )
 * @method Result createUser( array $args = [] )
 * @method Promise createUserAsync( array $args = [] )
 * @method Result deleteAlias( array $args = [] )
 * @method Promise deleteAliasAsync( array $args = [] )
 * @method Result deleteGroup( array $args = [] )
 * @method Promise deleteGroupAsync( array $args = [] )
 * @method Result deleteMailboxPermissions( array $args = [] )
 * @method Promise deleteMailboxPermissionsAsync( array $args = [] )
 * @method Result deleteResource( array $args = [] )
 * @method Promise deleteResourceAsync( array $args = [] )
 * @method Result deleteUser( array $args = [] )
 * @method Promise deleteUserAsync( array $args = [] )
 * @method Result deregisterFromWorkMail( array $args = [] )
 * @method Promise deregisterFromWorkMailAsync( array $args = [] )
 * @method Result describeGroup( array $args = [] )
 * @method Promise describeGroupAsync( array $args = [] )
 * @method Result describeOrganization( array $args = [] )
 * @method Promise describeOrganizationAsync( array $args = [] )
 * @method Result describeResource( array $args = [] )
 * @method Promise describeResourceAsync( array $args = [] )
 * @method Result describeUser( array $args = [] )
 * @method Promise describeUserAsync( array $args = [] )
 * @method Result disassociateDelegateFromResource( array $args = [] )
 * @method Promise disassociateDelegateFromResourceAsync( array $args = [] )
 * @method Result disassociateMemberFromGroup( array $args = [] )
 * @method Promise disassociateMemberFromGroupAsync( array $args = [] )
 * @method Result getMailboxDetails( array $args = [] )
 * @method Promise getMailboxDetailsAsync( array $args = [] )
 * @method Result listAliases( array $args = [] )
 * @method Promise listAliasesAsync( array $args = [] )
 * @method Result listGroupMembers( array $args = [] )
 * @method Promise listGroupMembersAsync( array $args = [] )
 * @method Result listGroups( array $args = [] )
 * @method Promise listGroupsAsync( array $args = [] )
 * @method Result listMailboxPermissions( array $args = [] )
 * @method Promise listMailboxPermissionsAsync( array $args = [] )
 * @method Result listOrganizations( array $args = [] )
 * @method Promise listOrganizationsAsync( array $args = [] )
 * @method Result listResourceDelegates( array $args = [] )
 * @method Promise listResourceDelegatesAsync( array $args = [] )
 * @method Result listResources( array $args = [] )
 * @method Promise listResourcesAsync( array $args = [] )
 * @method Result listUsers( array $args = [] )
 * @method Promise listUsersAsync( array $args = [] )
 * @method Result putMailboxPermissions( array $args = [] )
 * @method Promise putMailboxPermissionsAsync( array $args = [] )
 * @method Result registerToWorkMail( array $args = [] )
 * @method Promise registerToWorkMailAsync( array $args = [] )
 * @method Result resetPassword( array $args = [] )
 * @method Promise resetPasswordAsync( array $args = [] )
 * @method Result updateMailboxQuota( array $args = [] )
 * @method Promise updateMailboxQuotaAsync( array $args = [] )
 * @method Result updatePrimaryEmailAddress( array $args = [] )
 * @method Promise updatePrimaryEmailAddressAsync( array $args = [] )
 * @method Result updateResource( array $args = [] )
 * @method Promise updateResourceAsync( array $args = [] )
 */
class WorkMailClient extends AwsClient {
}