<?php
// This file was auto-generated from sdk-root/src/data/guardduty/2017-11-28/paginators-1.json
return [
	'pagination' => [
		'ListDetectors'       => [
			'input_token'  => 'NextToken',
			'output_token' => 'NextToken',
			'limit_key'    => 'MaxResults',
			'result_key'   => 'DetectorIds',
		],
		'ListFilters'         => [
			'input_token'  => 'NextToken',
			'output_token' => 'NextToken',
			'limit_key'    => 'MaxResults',
			'result_key'   => 'FilterNames',
		],
		'ListFindings'        => [
			'input_token'  => 'NextToken',
			'output_token' => 'NextToken',
			'limit_key'    => 'MaxResults',
			'result_key'   => 'FindingIds',
		],
		'ListIPSets'          => [
			'input_token'  => 'NextToken',
			'output_token' => 'NextToken',
			'limit_key'    => 'MaxResults',
			'result_key'   => 'IpSetIds',
		],
		'ListInvitations'     => [
			'input_token'  => 'NextToken',
			'output_token' => 'NextToken',
			'limit_key'    => 'MaxResults',
			'result_key'   => 'Invitations',
		],
		'ListMembers'         => [
			'input_token'  => 'NextToken',
			'output_token' => 'NextToken',
			'limit_key'    => 'MaxResults',
			'result_key'   => 'Members',
		],
		'ListThreatIntelSets' => [ 'input_token'  => 'NextToken',
		                           'output_token' => 'NextToken',
		                           'limit_key'    => 'MaxResults',
		                           'result_key'   => 'ThreatIntelSetIds',
		],
	],
];
