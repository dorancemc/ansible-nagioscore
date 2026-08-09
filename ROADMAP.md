# Roadmap

What comes next for this role. The order can change.

- **Move the configuration to its own role.** This role will keep the install and the base setup. A new role will handle the monitoring objects (hosts, services, contacts, commands) and will work with both Nagios Core and Nagios XI. A variable will select the backend: write `.cfg` files, or call the Nagios XI API.
- **Replace pnp4nagios with InfluxDB and Grafana.** Nagios keeps sending the performance data, so no agent is needed on the monitored hosts. This removes the compiler and the runtime patches from the server.
