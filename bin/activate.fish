# This file must be used with "source bin/activate.fish" *from fish*
# (https://fishshell.com/). You cannot run it directly.
# Source: https://github.com/python/cpython/blob/main/Lib/venv/scripts/common/activate.fish#L27

function deactivate  -d "Exit virtual environment and return to normal shell environment"
    # reset old environment variables
    if test -n "$_OLD_VIRTUAL_PATH"
        set -gx PATH $_OLD_VIRTUAL_PATH
        set -e _OLD_VIRTUAL_PATH
    end

    if test -n "$_OLD_FISH_PROMPT_OVERRIDE"
        set -e _OLD_FISH_PROMPT_OVERRIDE
        # prevents error when using nested fish instances (Issue #93858)
        if functions -q _old_fish_prompt
            functions -e fish_prompt
            functions -c _old_fish_prompt fish_prompt
            functions -e _old_fish_prompt
        end
    end

    set -e VIRTUAL_ENV
    set -e VIRTUAL_ENV_PROMPT
    if test "$argv[1]" != "nondestructive"
        # Self-destruct!
        functions -e deactivate
    end

    # Unset sail aliases in one command
    functions -e sail artisan php composer node npm pnpm mariadb shell root-shell tinker share open
end

# Unset irrelevant variables.
deactivate nondestructive

set -gx VIRTUAL_ENV "$PWD"

set -gx _OLD_VIRTUAL_PATH $PATH
set -gx PATH "$VIRTUAL_ENV/bin" $PATH
set -gx VIRTUAL_ENV_PROMPT "(sail) "

# Set sail aliases
alias sail="docker compose"
alias artisan="./vendor/bin/sail artisan"
alias php="./vendor/bin/sail php"
alias composer="./vendor/bin/sail composer"
alias node="./vendor/bin/sail node"
alias npm="./vendor/bin/sail npm"
alias pnpm="./vendor/bin/sail pnpm"
alias mariadb="./vendor/bin/sail mariadb"
alias shell="./vendor/bin/sail shell"
alias root-shell="./vendor/bin/sail root-shell"
alias tinker="./vendor/bin/sail tinker"
alias share="./vendor/bin/sail share"
alias open="./vendor/bin/sail open"

if test -z "$VIRTUAL_ENV_DISABLE_PROMPT"
    # fish uses a function instead of an env var to generate the prompt.

    # Save the current fish_prompt function as the function _old_fish_prompt.
    functions -c fish_prompt _old_fish_prompt

    # With the original prompt function renamed, we can override with our own.
    function fish_prompt
        # Save the return status of the last command.
        set -l old_status $status

        # Output the venv prompt; color taken from the blue of the Python logo.
        printf "%s(%s)%s " (set_color 4B8BBE) __VENV_PROMPT__ (set_color normal)

        # Restore the return status of the previous command.
        echo "exit $old_status" | .
        # Output the original/"old" prompt.
        _old_fish_prompt
    end

    set -gx _OLD_FISH_PROMPT_OVERRIDE "$PWD"
end
