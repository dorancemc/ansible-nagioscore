Nagios Core
=========

Role to deploy Nagios Core

Requirements
------------

None

Role Variables
--------------

Objects are defined in yaml files, and converted to configuration files from templates.  
You can view more details for variables in default/main folder  

Variables defined per Operative System are defined in vars/ folder.  

Replace the default values in vars.yaml file, and encrypt this file.  

To modify variable data, copy the folder nagios located inside 
of main folder to your local inventory folder, preferably in the group_vars/ 
or host_vars/ folder

### - Hosts and Services
Hosts and services could be defined in one variable or per file.  
In nagios_hosts.yaml you will find an example to define new hosts.
Copy nagios_hosts.yaml file in your group_var add more elements as a list.   

You can create files per host to define host and services. Create the folder 
and update variable to indicate the path location for files.  
`# nagios_hosts_path: inventory/nagios_hosts`
 
On inventory folder creates a file like this:
```yaml
_host:
  name: hostname #required
  address: 192.168.0.1 #if is not defined, is replaced by the name
  alias: Server Description
  use: template #if is not defined, then take 'server' as default template
  services:
    servicename: servicecommand!arguments #in one line the service is defined with 'generic-service' as service template
    servicename-other: 
      use: service_template
      check_command: servicecommand!arguments!arguments #syntax: <command_name>!$ARG1$!$ARG2$
                                                        #check the commands.yaml file to validate the servicecommand and parameters

```

Define the hostgroups and servicegroups in `nagios_hostgroups` and `nagios_servicegroups` variables,  
then you can add if one host and service belongs in there.

### - Contacts
Check the contacts.yaml to get more details about variables.
To ensure the user was deleted from httpasswd file, add the data `state: absent` on the contact definition, 
the user will be deleted from contacts definition and the htpasswd file.

### - Contact Groups
Contact groups are the best way to handle notifications, create a contact, and join groups. 
If a contact_group is defined on the host, all services inherit the same contact group, 
or you can define one contact group per service

Dependencies
------------

None

Example Playbook
----------------

Define your nagios group and include all your nagios servers there
```ini
[nagios]
nagios.example.com ansible_host=192.168.243.220
```

Include this in your playbook default:

```yaml
- hosts: nagios
  roles:
    - { role: dorancemc.ansible-nagioscore, tags: [ nagioscore ] }
```

Run your playbook to apply this role
```bash
ansible-playbook --limit ubuntu playbook.yaml --tags nagioscore
```

If you want to apply only the configuration just apply the `nagios_config` tag 
```bash
ansible-playbook --limit ubuntu playbook.yaml --tags nagios_config
```

Grafana
-------

This deploy support integration with grafana. After deploy you can install grafana manually  
and follow this instructions to complete the integration.  
https://support.nagios.com/kb/article/nagios-core-using-grafana-with-pnp4nagios-803.html#Grafana_Config

Or use the ansible recipe and configure these variables to complete the integration.   
https://github.com/cloudalchemy/ansible-grafana

```yaml
grafana_plugins:
  - sni-pnp-datasource

grafana_datasources:
  - name: PNP
    type: sni-pnp-datasource
    isDefault: true
    access: proxy
    url: 'http://127.0.0.1/pnp4nagios/'
    basicAuth: false
```

License
-------

BSD

Author Information
------------------

Dorance Martinez @dorancemc
