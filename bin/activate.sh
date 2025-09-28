# This file must be used with "source bin/activate" *from bash*
# You cannot run it directly

deactivate () {
    # reset old environment variables
    if [ -n "${_OLD_VIRTUAL_PATH:-}" ] ; then
        PATH="${_OLD_VIRTUAL_PATH:-}"
        export PATH
        unset _OLD_VIRTUAL_PATH
    fi

    # Call hash to forget past locations. Without forgetting
    # past locations the $PATH changes we made may not be respected.
    # See "man bash" for more details. hash is usually a builtin of your shell
    hash -r 2> /dev/null

    if [ -n "${_OLD_VIRTUAL_PS1:-}" ] ; then
        PS1="${_OLD_VIRTUAL_PS1:-}"
        export PS1
        unset _OLD_VIRTUAL_PS1
    fi

    unset VIRTUAL_ENV
    unset VIRTUAL_ENV_PROMPT
    if [ ! "${1:-}" = "nondestructive" ] ; then
    # Self destruct!
        unset -f deactivate
    fi

    # Unset sail aliases if they exist in one command (check if they exist before unsetting)
    for alias in sail artisan php composer node npm pnpm mariadb shell root-shell tinker share open; do
        if [ -n "$(alias | grep $alias)" ]; then
            unalias $alias
        fi
    done
}

# unset irrelevant variables
deactivate nondestructive

export VIRTUAL_ENV="$PWD"

_OLD_VIRTUAL_PATH="$PATH"
PATH="$VIRTUAL_ENV/bin:$PATH"
export PATH

# Set sail aliases
alias sail='docker compose'
alias artisan='./vendor/bin/sail artisan'
alias php='./vendor/bin/sail php'
alias composer='./vendor/bin/sail composer'
alias node='./vendor/bin/sail node'
alias npm='./vendor/bin/sail npm'
alias pnpm='./vendor/bin/sail pnpm'
alias mariadb='./vendor/bin/sail mariadb'
alias shell='./vendor/bin/sail shell'
alias root-shell='./vendor/bin/sail root-shell'
alias tinker='./vendor/bin/sail tinker'
alias share='./vendor/bin/sail share'
alias open='./vendor/bin/sail open'

if [ -z "${VIRTUAL_ENV_DISABLE_PROMPT:-}" ] ; then
    _OLD_VIRTUAL_PS1="${PS1:-}"
    PS1="(sail) ${PS1:-}"
    export PS1
    VIRTUAL_ENV_PROMPT="(sail) "
    export VIRTUAL_ENV_PROMPT
fi

# Call hash to forget past commands. Without forgetting
# past commands the $PATH changes we made may not be respected
hash -r 2> /dev/null
