export ZSH=$HOME/.oh-my-zsh

# Config
ZSH_THEME="gentoo"
MOUNT_PATH="$HOME/Mount/"
SSH_KEY="$HOME/.ssh/id_rsa"
plugins=(git)

# System
export PATH="/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin"
export EDITOR="vim"
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8

source $ZSH/oh-my-zsh.sh
