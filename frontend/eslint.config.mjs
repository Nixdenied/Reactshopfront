import globals from 'globals';
import pluginJs from '@eslint/js';
import pluginReactConfig from 'eslint-plugin-react/configs/recommended.js';

export default [
  {
    files: ['src/**/*.js', 'src/**/*.jsx'],
    languageOptions: {
      globals: globals.browser
    }
  },
  pluginJs.configs.recommended,
  pluginReactConfig,
  {
    rules: {
      quotes: ['error', 'single'],
      'no-console': 'warn',
      semi: ['error', 'never'],
      indent: ['error', 2],
      'comma-dangle': ['error', 'always-multiline'],
      'no-unused-vars': 'warn',
      'no-trailing-spaces': 'error',
      'eol-last': ['error', 'always'],
      'react/prop-types': 'off',
      'spaced-comment': ['error', 'always', { exceptions: ['-'] }],
      'multiline-comment-style': ['error', 'starred-block']
    }
  }
];
