<?php
namespace Broadlog\Metrics;

snmp_read_mib(base_path(__DIR__).'/MIB/BW-Execution.mib');
snmp_set_oid_output_format(SNMP_OID_OUTPUT_FULL);
snmprealwalk('', '', 'BW-Execution');