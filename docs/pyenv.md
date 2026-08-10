# Install Ansible with pyenv on macOS

`pyenv` lets you switch between several Python versions on the same machine. With
the `pyenv-virtualenv` plugin you can also keep one virtual environment per tool,
so an Ansible upgrade never breaks another project.

The full documentation is at <https://github.com/pyenv/pyenv>.

## 1. Install pyenv

```bash
brew install pyenv pyenv-virtualenv
```

## 2. Set up your shell

`pyenv` only works after you add it to your shell configuration:

```bash
echo 'export PYENV_ROOT="$HOME/.pyenv"' >> ~/.zshrc
echo 'command -v pyenv >/dev/null || export PATH="$PYENV_ROOT/bin:$PATH"' >> ~/.zshrc
echo 'eval "$(pyenv init -)"' >> ~/.zshrc
echo 'eval "$(pyenv virtualenv-init -)"' >> ~/.zshrc
```

Open a new terminal, or run `exec zsh`, so the changes take effect.

If you also want pyenv in non-interactive login shells, add the same four lines to
`~/.zprofile` or `~/.zlogin`.

## 3. Create the environment and install Ansible

```bash
pyenv install 3.14
pyenv virtualenv 3.14 python_3.14_ansible_13.3
pyenv activate python_3.14_ansible_13.3
pip install --upgrade pip
pip install "ansible==13.3" ansible-lint pyfiglet pyaml jmespath passlib yamllint netaddr kubernetes
pyenv deactivate
```

The name `python_3.14_ansible_13.3` says which Python and which Ansible are inside.
Keep that pattern, because you will probably have more than one environment later.

Install `ansible`, not `ansible-core`. The full package brings the collections this
role needs, such as `ansible.posix` and `community.general`. With `ansible-core`
alone the role fails.

## 4. Use it in the project

This repository has a `.python-version` file, so the environment is selected on its
own when you enter the folder. You do not need to activate it by hand.

For a different project, run this once inside the folder:

```bash
pyenv local python_3.14_ansible_13.3
```

## 5. Check that it works

```bash
ansible --version
ansible-lint --version
yamllint --version
```

`ansible --version` should print the path of your pyenv environment. If it points
somewhere else, your shell is still using another Python and step 2 did not work.
