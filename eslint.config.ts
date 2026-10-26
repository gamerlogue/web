import config from '@maicol07/eslint-config';

/** @antfu/eslint-config 9.5.1 lints SCSS and XML for slop/no-em-dash with no parser, so espree fails on them; drop when fixed upstream. */
export default config.append({ignores: ['**/*.scss', '**/*.xml']});
