
mkdir includes\attachments
mkdir includes\logs
mkdir includes\cache
mkdir includes\users
mkdir includes\user_data

copy /-Y install\configVars.php.default includes\configVars.php
copy /-Y install\header.php.default www\header.php
copy /-Y install\egate_config.php.default includes\egate_config.php
