# Nagios Core

Deploy and configure Nagios Core with Apache, optional NRDP and PNP4Nagios, and monitoring object definitions.

## Requirements

- Ansible 2.20 or newer
- Target hosts running Debian, Ubuntu, or Oracle Linux 8
- Root privileges on target hosts

## Example Playbook

```ini
[nagios]
nagios.example.com ansible_host=192.168.243.220
```

```yaml
- hosts: nagios
  become: true
  roles:
    - role: dorancemc.ansible-nagioscore
      tags:
        - ansible_nagioscore
```

Apply the full role:

```bash
ansible-playbook --limit nagios playbook.yml --tags ansible_nagioscore
```

Apply configuration only:

```bash
ansible-playbook --limit nagios playbook.yml --tags nagios-config
```

Define credentials in inventory vault variables such as `vault_nagiosadmin_password`, `vault_rouser_password`, and `vault_nrdp_mysecrettoken`.
