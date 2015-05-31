<?php
/*****************************************************************************
 * The contents of this file are subject to the RECIPROCAL PUBLIC LICENSE
 * Version 1.1 ("License"); You may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 * http://opensource.org/licenses/rpl.php. Software distributed under the
 * License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND,
 * either express or implied.
 *
 * @author:  Mr. Milk (aka Marcelo Leite)
 * @email:   mrmilk@anysoft.com.br
 * @version: 0.9 beta
 * @date:    2007-07-07
 *
 *****************************************************************************/
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

define('_PHP50', 50000);
define('_PHP51', 50100);
define('_PHP53', 50300);
define('_PHP54', 50400);
define('_PHP55', 50500);
define('_PHP56', 50600);
define('_PHP70', 70000);

if (PHP_VERSION_ID < _PHP70) {
    define('T_SPACESHIP', 'T_SPACESHIP');
}
if (PHP_VERSION_ID < _PHP56) {
    define('T_POW', 'T_POW');
    define('T_POW_EQUAL', 'T_POW_EQUAL');
    define('T_ELLIPSIS', 'T_ELLIPSIS');
}
if (PHP_VERSION_ID < _PHP55) {
    define('T_FINALLY', 'T_FINALLY');
    define('T_YIELD', 'T_YIELD');
}
if (PHP_VERSION_ID < _PHP54) {
    define('T_TRAIT', 'T_TRAIT');
    define('T_INSTEADOF', 'T_INSTEADOF');
    define('T_TRAIT_C', 'T_TRAIT_C');
}
if (PHP_VERSION_ID < _PHP53) {
    define('T_USE', 'T_USE');
    define('T_NS_SEPARATOR', 'T_NS_SEPARATOR');
    define('T_DIR', 'T_DIR');
    define('T_GOTO', 'T_GOTO');
    define('T_NAMESPACE', 'T_NAMESPACE');
    define('T_NS_C', 'T_NS_C');
}
if (PHP_VERSION_ID < _PHP51) {
    define('T_HALT_COMPILER', 'T_HALT_COMPILER');
}
if (PHP_VERSION_ID < _PHP50) {
    define('T_INTERFACE', 'T_INTERFACE');
    define('T_INSTANCEOF', 'T_INSTANCEOF');
    define('T_FINAL', 'T_FINAL');
    define('T_ABSTRACT', 'T_ABSTRACT');
    define('T_PUBLIC', 'T_PUBLIC');
    define('T_PROTECTED', 'T_PROTECTED');
    define('T_PRIVATE', 'T_PRIVATE');
    define('T_IMPLEMENTS', 'T_IMPLEMENTS');
    define('T_CLONE', 'T_CLONE');
    define('T_CATCH', 'T_CATCH');
}

define('S_OPEN_CURLY', '{');
define('S_CLOSE_CURLY', '}');
define('S_OPEN_BRACKET', '[');
define('S_CLOSE_BRACKET', ']');
define('S_OPEN_PARENTH', '(');
define('S_CLOSE_PARENTH', ')');
define('S_SEMI_COLON', ';');
define('S_COMMA', ',');
define('S_CONCAT', '.');
define('S_COLON', ':');
define('S_QUESTION', '?');
define('S_EQUAL', '=');
define('S_EXCLAMATION', '!');
define('S_IS_GREATER', '>');
define('S_IS_SMALLER', '<');
define('S_MINUS', '-');
define('S_PLUS', '+');
define('S_TIMES', '*');
define('S_DIVIDE', '/');
define('S_MODULUS', '%');
define('S_REFERENCE', '&');
define('S_QUOTE', '"');
define('S_AT', '@');
define('S_DOLLAR', '$');
define('S_ABSTRACT', 'abstract');
define('S_INTERFACE', 'interface');
define('S_FINAL', 'final');
define('S_PUBLIC', 'public');
define('S_PRIVATE', 'private');
define('S_PROTECTED', 'protected');
if (defined('T_ML_COMMENT')) {
    define('T_DOC_COMMENT', T_ML_COMMENT);
}
elseif (defined('T_DOC_COMMENT')) {
    define('T_ML_COMMENT', T_DOC_COMMENT);
}


class phpStylist
{
  var $indent_size = 2;
  var $indent_char = " ";
  var $block_size  = 3;
  var $options = array(
    "SPACE_INSIDE_PARENTHESES"    => false,
    "SPACE_OUTSIDE_PARENTHESES"   => false,
    "SPACE_INSIDE_FOR"            => false,
    "SPACE_AFTER_IF"              => false,
    "SPACE_AFTER_COMMA"           => false,
    "SPACE_AROUND_OBJ_OPERATOR"   => false,
    "SPACE_AROUND_DOUBLE_COLON"   => false,
    "SPACE_AROUND_DOUBLE_ARROW"   => false,
    "SPACE_AROUND_ASSIGNMENT"     => false,
    "SPACE_AROUND_COMPARISON"     => false,
    "SPACE_AROUND_COLON_QUESTION" => false,
    "SPACE_AROUND_LOGICAL"        => false,
    "SPACE_AROUND_ARITHMETIC"     => false,
    "SPACE_AROUND_CONCAT"         => false,
    "LINE_BEFORE_FUNCTION"        => false,
    "LINE_BEFORE_CURLY"           => false,
    "LINE_BEFORE_CURLY_FUNCTION"  => false,
    "LINE_AFTER_CURLY_FUNCTION"   => false,
    "LINE_BEFORE_ARRAY"           => false,
    "LINE_BEFORE_COMMENT"         => false,
    "LINE_AFTER_COMMENT"          => false,
    "LINE_BEFORE_COMMENT_MULTI"   => false,
    "LINE_AFTER_COMMENT_MULTI"    => false,
    "LINE_AFTER_BREAK"            => false,
    "VERTICAL_CONCAT"             => false,
    "VERTICAL_ARRAY"              => false,
    "INDENT_CASE"                 => false,
    "KEEP_REDUNDANT_LINES"        => false,
    "ADD_MISSING_BRACES"          => false,
    "ALIGN_ARRAY_ASSIGNMENT"      => false,
    "ALIGN_VAR_ASSIGNMENT"        => false,
    "ELSE_ALONG_CURLY"            => false,
  );
  var $_new_line = "\n";
  var $_indent   = 0;
  var $_for_idx  = 0;
  var $_code     = "";
  var $_log      = false;
  var $_pointer  = 0;
  var $_tokens   = 0;

  function phpStylist()
  {
  }

  function formatCode($source = '')
  {
    $in_for        = false;
    $in_break      = false;
    $in_function   = false;
    $in_concat     = false;
    $space_after   = false;
    $curly_open    = false;
    $array_level   = 0;
    $arr_parenth   = array();
    $switch_level  = 0;
    $if_level      = 0;
    $if_pending    = 0;
    $else_pending  = false;
    $if_parenth    = array();
    $switch_arr    = array();
    $halt_parser   = false;
    $after         = false;
    $this->_tokens = token_get_all($source);
    foreach ($this->_tokens as $index => $token) {
      list($id, $text) = $this->_get_token($token);
      $this->_pointer = $index;
      if ($halt_parser && $id != S_QUOTE) {
        $this->_append_code($text, false);
        continue;
      }
      if (substr(phpversion(), 0, 1) == "4" && $id == T_STRING) {
        switch (strtolower(trim($text))) {
          case S_ABSTRACT:
          case S_INTERFACE:
          case S_FINAL:
          case S_PUBLIC:
          case S_PRIVATE:
          case S_PROTECTED:
            $id = T_PUBLIC;
          default:
        }
      }

      switch ($id) {
        case T_NS_SEPARATOR:
          $this->_append_code($text, false);
          break;

        case S_OPEN_CURLY:
          $condition = $in_function ? $this->options["LINE_BEFORE_CURLY_FUNCTION"] : $this->options["LINE_BEFORE_CURLY"];
          $this->_set_indent( + 1);
          $this->_append_code((!$condition ? ' ' : $this->_get_crlf_indent(false, - 1)) . $text . $this->_get_crlf($this->options["LINE_AFTER_CURLY_FUNCTION"] && $in_function && !$this->_is_token_lf()) . $this->_get_crlf_indent());
          $in_function = false;
          break;

        case S_CLOSE_CURLY:
          if ($curly_open) {
            $curly_open = false;
            $this->_append_code(trim($text));
          }
          else {
            if (($in_break || $this->_is_token(S_CLOSE_CURLY)) && $switch_level > 0 && $switch_arr["l" . $switch_level] > 0 && $switch_arr["s" . $switch_level] == $this->_indent - 2) {
              if ($this->options["INDENT_CASE"]) {
                $this->_set_indent( - 1);
              }
              $switch_arr["l" . $switch_level]--;
              $switch_arr["c" . $switch_level]--;
            }
            while ($switch_level > 0 && $switch_arr["l" . $switch_level] == 0 && $this->options["INDENT_CASE"]) {
              unset($switch_arr["s" . $switch_level]);
              unset($switch_arr["c" . $switch_level]);
              unset($switch_arr["l" . $switch_level]);
              $switch_level--;
              if ($switch_level > 0) {
                $switch_arr["l" . $switch_level]--;
              }
              $this->_set_indent( - 1);
              $this->_append_code($this->_get_crlf_indent() . $text . $this->_get_crlf_indent());
              $text = '';
            }
            if ($text != '') {
              $this->_set_indent( - 1);
              $this->_append_code($this->_get_crlf_indent() . $text . $this->_get_crlf_indent());
            }
          }
          break;

        case S_SEMI_COLON:
          if (($in_break || $this->_is_token(S_CLOSE_CURLY)) && $switch_level > 0 && $switch_arr["l" . $switch_level] > 0 && $switch_arr["s" . $switch_level] == $this->_indent - 2) {
            if ($this->options["INDENT_CASE"]) {
              $this->_set_indent( - 1);
            }
            $switch_arr["l" . $switch_level]--;
            $switch_arr["c" . $switch_level]--;
          }
          if ($in_concat) {
            $this->_set_indent( - 1);
            $in_concat = false;
          }
          $this->_append_code($text . $this->_get_crlf($this->options["LINE_AFTER_BREAK"] && $in_break) . $this->_get_crlf_indent($in_for));
          while ($if_pending > 0) {
            $text = $this->options["ADD_MISSING_BRACES"] ? "}" : "";
            $this->_set_indent( - 1);
            if ($text != "") {
              $this->_append_code($this->_get_crlf_indent() . $text . $this->_get_crlf_indent());
            }
            else {
              $this->_append_code($this->_get_crlf_indent());
            }
            $if_pending--;
            if ($this->_is_token(array(T_ELSE, T_ELSEIF))) {
              break;
            }
          }
          if ($this->_for_idx == 0) {
            $in_for = false;
          }
          $in_break = false;
          $in_function = false;
          break;

        case S_OPEN_BRACKET:
        case S_CLOSE_BRACKET:
          $this->_append_code($text);
          break;

        case S_OPEN_PARENTH:
          if ($if_level > 0) {
            $if_parenth["i" . $if_level]++;
          }
          if ($array_level > 0) {
            $arr_parenth["i" . $array_level]++;
            if ($this->_is_token(array(T_ARRAY), true) && !$this->_is_token(S_CLOSE_PARENTH)) {
              $this->_set_indent( + 1);
              $this->_append_code((!$this->options["LINE_BEFORE_ARRAY"] ? '' : $this->_get_crlf_indent(false, - 1)) . $text . $this->_get_crlf_indent());
              break;
            }
          }
          $this->_append_code($this->_get_space($this->options["SPACE_OUTSIDE_PARENTHESES"] || $space_after) . $text . $this->_get_space($this->options["SPACE_INSIDE_PARENTHESES"]));
          $space_after = false;
          break;

        case S_CLOSE_PARENTH:
          if ($array_level > 0) {
            $arr_parenth["i" . $array_level]--;
            if ($arr_parenth["i" . $array_level] == 0) {
              $comma = substr(trim($this->_code), - 1) != "," && $this->options['VERTICAL_ARRAY'] ? "," : "";
              $this->_set_indent( - 1);
              $this->_append_code($comma . $this->_get_crlf_indent() . $text . $this->_get_crlf_indent());
              unset($arr_parenth["i" . $array_level]);
              $array_level--;
              break;
            }
          }
          $this->_append_code($this->_get_space($this->options["SPACE_INSIDE_PARENTHESES"]) . $text . $this->_get_space($this->options["SPACE_OUTSIDE_PARENTHESES"]));
          if ($if_level > 0) {
            $if_parenth["i" . $if_level]--;
            if ($if_parenth["i" . $if_level] == 0) {
              if (!$this->_is_token(S_OPEN_CURLY) && !$this->_is_token(S_SEMI_COLON)) {
                $text = $this->options["ADD_MISSING_BRACES"] ? "{" : "";
                $this->_set_indent( + 1);
                $this->_append_code((!$this->options["LINE_BEFORE_CURLY"] || $text == "" ? ' ' : $this->_get_crlf_indent(false, - 1)) . $text . $this->_get_crlf_indent());
                $if_pending++;
              }
              unset($if_parenth["i" . $if_level]);
              $if_level--;
            }
          }
          break;

        case S_COMMA:
          if ($array_level > 0) {
            $this->_append_code($text . $this->_get_crlf_indent($in_for));
          }
          else {
            $this->_append_code($text . $this->_get_space($this->options["SPACE_AFTER_COMMA"]));
            if ($this->_is_token(S_OPEN_PARENTH)) {
              $space_after = $this->options["SPACE_AFTER_COMMA"];
            }
          }
          break;

        case S_CONCAT:
          $condition = $this->options["SPACE_AROUND_CONCAT"];
          if ($this->_is_token(S_OPEN_PARENTH)) {
            $space_after = $condition;
          }
          if ($this->options["VERTICAL_CONCAT"]) {
            if (!$in_concat) {
              $in_concat = true;
              $this->_set_indent( + 1);
            }
            $this->_append_code($this->_get_space($condition) . $text . $this->_get_crlf_indent());
          }
          else {
            $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          }
          break;

        case T_CONCAT_EQUAL:
        case T_DIV_EQUAL:
        case T_MINUS_EQUAL:
        case T_PLUS_EQUAL:
        case T_MOD_EQUAL:
        case T_MUL_EQUAL:
        case T_AND_EQUAL:
        case T_OR_EQUAL:
        case T_XOR_EQUAL:
        case T_SL_EQUAL:
        case T_SR_EQUAL:
        case S_EQUAL:
          $condition = $this->options["SPACE_AROUND_ASSIGNMENT"];
          if ($this->_is_token(S_OPEN_PARENTH)) {
            $space_after = $condition;
          }
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case T_IS_EQUAL:
        case S_IS_GREATER:
        case T_IS_GREATER_OR_EQUAL:
        case T_IS_SMALLER_OR_EQUAL:
        case S_IS_SMALLER:
        case T_IS_IDENTICAL:
        case T_IS_NOT_EQUAL:
        case T_IS_NOT_IDENTICAL:
          $condition = $this->options["SPACE_AROUND_COMPARISON"];
          if ($this->_is_token(S_OPEN_PARENTH)) {
            $space_after = $condition;
          }
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case T_BOOLEAN_AND:
        case T_BOOLEAN_OR:
        case T_LOGICAL_AND:
        case T_LOGICAL_OR:
        case T_LOGICAL_XOR:
        case T_SL:
        case T_SR:
          $condition = $this->options["SPACE_AROUND_LOGICAL"];
          if ($this->_is_token(S_OPEN_PARENTH)) {
            $space_after = $condition;
          }
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case T_DOUBLE_COLON:
          $condition = $this->options["SPACE_AROUND_DOUBLE_COLON"];
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case S_COLON:
          if ($switch_level > 0 && $switch_arr["l" . $switch_level] > 0 && $switch_arr["c" . $switch_level] < $switch_arr["l" . $switch_level]) {
            $switch_arr["c" . $switch_level]++;
            if ($this->options["INDENT_CASE"]) {
              $this->_set_indent( + 1);
            }
            $this->_append_code($text . $this->_get_crlf_indent());
          }
          else {
            $condition = $this->options["SPACE_AROUND_COLON_QUESTION"];
            if ($this->_is_token(S_OPEN_PARENTH)) {
              $space_after = $condition;
            }
            $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          }
          if (($in_break || $this->_is_token(S_CLOSE_CURLY)) && $switch_level > 0 && $switch_arr["l" . $switch_level] > 0) {
            if ($this->options["INDENT_CASE"]) {
              $this->_set_indent( - 1);
            }
            $switch_arr["l" . $switch_level]--;
            $switch_arr["c" . $switch_level]--;
          }
          break;

        case S_QUESTION:
          $condition = $this->options["SPACE_AROUND_COLON_QUESTION"];
          if ($this->_is_token(S_OPEN_PARENTH)) {
            $space_after = $condition;
          }
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case T_DOUBLE_ARROW:
          $condition = $this->options["SPACE_AROUND_DOUBLE_ARROW"];
          if ($this->_is_token(S_OPEN_PARENTH)) {
            $space_after = $condition;
          }
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case S_MINUS:
        case S_PLUS:
        case S_TIMES:
        case S_DIVIDE:
        case S_MODULUS:
          $condition = $this->options["SPACE_AROUND_ARITHMETIC"];
          if ($this->_is_token(S_OPEN_PARENTH)) {
            $space_after = $condition;
          }
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case T_OBJECT_OPERATOR:
          $condition = $this->options["SPACE_AROUND_OBJ_OPERATOR"];
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($condition));
          break;

        case T_FOR:
          $in_for = true;
        case T_FOREACH:
        case T_WHILE:
        case T_DO:
        case T_IF:
        case T_SWITCH:
          $space_after = $this->options["SPACE_AFTER_IF"];
          $this->_append_code($text . $this->_get_space($space_after), false);
          if ($id == T_SWITCH) {
            $switch_level++;
            $switch_arr["s" . $switch_level] = $this->_indent;
            $switch_arr["l" . $switch_level] = 0;
            $switch_arr["c" . $switch_level] = 0;
          }
          $if_level++;
          $if_parenth["i" . $if_level] = 0;
          break;

        case T_FUNCTION:
        case T_CLASS:
        case T_INTERFACE:
        case T_FINAL:
        case T_ABSTRACT:
        case T_PUBLIC:
        case T_PROTECTED:
        case T_PRIVATE:
          if (!$in_function) {
            if ($this->options["LINE_BEFORE_FUNCTION"]) {
              $this->_append_code($this->_get_crlf($after || !$this->_is_token(array(T_COMMENT, T_ML_COMMENT, T_DOC_COMMENT), true)) . $this->_get_crlf_indent() . $text . $this->_get_space());
              $after = false;
            }
            else {
              $this->_append_code($text . $this->_get_space(), false);
            }
            $in_function = true;
          }
          else {
            $this->_append_code($this->_get_space() . $text . $this->_get_space());
          }
          break;

        case T_START_HEREDOC:
          $this->_append_code($this->_get_space($this->options["SPACE_AROUND_ASSIGNMENT"]) . $text);
          break;

        case T_END_HEREDOC:
          $this->_append_code($this->_get_crlf() . $text . $this->_get_crlf_indent());
          break;

        case T_COMMENT:
        case T_ML_COMMENT:
        case T_DOC_COMMENT:
          if (is_array($this->_tokens[$index - 1])) {
            $pad = $this->_tokens[$index - 1][1];
            $i   = strlen($pad) - 1;
            $k   = "";
            while (substr($pad, $i, 1) != "\n" && substr($pad, $i, 1) != "\r" && $i >= 0) {
              $k .= substr($pad, $i--, 1);
            }
            $text = preg_replace("/\r?\n$k/", $this->_get_crlf_indent(), $text);
          }
          $after = $id == (T_COMMENT && preg_match("/^\/\//", $text)) ? $this->options["LINE_AFTER_COMMENT"] : $this->options["LINE_AFTER_COMMENT_MULTI"];
          $before = $id == (T_COMMENT && preg_match("/^\/\//", $text)) ? $this->options["LINE_BEFORE_COMMENT"] : $this->options["LINE_BEFORE_COMMENT_MULTI"];
          if ($prev = $this->_is_token(S_OPEN_CURLY, true, $index, true)) {
            $before = $before && !$this->_is_token_lf(true, $prev);
          }
          $after = $after && (!$this->_is_token_lf() || !$this->options["KEEP_REDUNDANT_LINES"]);
          if ($before) {
            $this->_append_code($this->_get_crlf(!$this->_is_token(array(T_COMMENT), true)) . $this->_get_crlf_indent() . trim($text) . $this->_get_crlf($after) . $this->_get_crlf_indent());
          }
          else {
            $this->_append_code(trim($text) . $this->_get_crlf($after) . $this->_get_crlf_indent(), false);
          }
          break;

        case T_DOLLAR_OPEN_CURLY_BRACES:
        case T_CURLY_OPEN:
          $curly_open = true;
        case T_NUM_STRING:
        case T_BAD_CHARACTER:
          $this->_append_code(trim($text));
          break;

        case T_EXTENDS:
        case T_IMPLEMENTS:
        case T_INSTANCEOF:
        case T_AS:
          $this->_append_code($this->_get_space() . $text . $this->_get_space());
          break;

        case S_DOLLAR:
        case S_REFERENCE:
        case T_INC:
        case T_DEC:
          $this->_append_code(trim($text), false);
          break;

        case T_WHITESPACE:
          $redundant = "";
          if ($this->options["KEEP_REDUNDANT_LINES"]) {
            $lines          = preg_match_all("/\r?\n/", $text, $matches);
            $lines          = $lines > 0 ? $lines - 1 : 0;
            $redundant      = $lines > 0 ? str_repeat($this->_new_line, $lines) : "";
            $current_indent = $this->_get_indent();
            if (substr($this->_code, strlen($current_indent) * - 1) == $current_indent && $lines > 0) {
              $redundant .= $current_indent;
            }
          }
          if($this->_is_token(array(T_OPEN_TAG), true)) {
            $this->_append_code($text, false);
          }
          else {
            $this->_append_code($redundant . trim($text), false);
          }
          break;

        case S_QUOTE:
          $this->_append_code($text, false);
          $halt_parser = !$halt_parser;
          break;

        case T_ARRAY:
          if ($this->options["VERTICAL_ARRAY"]) {
            $next = $this->_is_token(array(T_DOUBLE_ARROW), true);
            $next |= $this->_is_token(S_EQUAL, true);
            $next |= $array_level>0;
            if ($next) {
              $next = $this->_is_token(S_OPEN_PARENTH, false, $index, true);
              if ($next) {
                $next = !$this->_is_token(S_CLOSE_PARENTH, false, $next);
              }
            }
            if ($next) {
              $array_level++;
              $arr_parenth["i" . $array_level] = 0;
            }
          }
        case T_STRING:
        case T_CONSTANT_ENCAPSED_STRING:
        case T_ENCAPSED_AND_WHITESPACE:
        case T_VARIABLE:
        case T_CHARACTER:
        case T_STRING_VARNAME:
        case S_AT:
        case S_EXCLAMATION:
        case T_OPEN_TAG:
        case T_OPEN_TAG_WITH_ECHO:
          $this->_append_code($text, false);
          break;

        case T_CLOSE_TAG:
          $this->_append_code($text, !$this->_is_token_lf(true));
          break;

        case T_CASE:
        case T_DEFAULT:
          if ($switch_arr["l" . $switch_level] > 0 && $this->options["INDENT_CASE"]) {
            $switch_arr["c" . $switch_level]--;
            $this->_set_indent( - 1);
            $this->_append_code($this->_get_crlf_indent() . $text . $this->_get_space());
          }
          else {
            $switch_arr["l" . $switch_level]++;
            $this->_append_code($text . $this->_get_space(), false);
          }
          break;

        case T_INLINE_HTML:
          $this->_append_code($text, false);
          break;

        case T_BREAK:
        case T_CONTINUE:
          $in_break = true;
        case T_VAR:
        case T_GLOBAL:
        case T_STATIC:
        case T_CONST:
        case T_ECHO:
        case T_PRINT:
        case T_INCLUDE:
        case T_INCLUDE_ONCE:
        case T_REQUIRE:
        case T_REQUIRE_ONCE:
        case T_DECLARE:
        case T_EMPTY:
        case T_ISSET:
        case T_UNSET:
        case T_DNUMBER:
        case T_LNUMBER:
        case T_RETURN:
        case T_EVAL:
        case T_EXIT:
        case T_LIST:
        case T_CLONE:
        case T_NEW:
        case T_FUNC_C:
        case T_CLASS_C:
        case T_FILE:
        case T_LINE:
        case T_USE:
        case T_NAMESPACE:
          $this->_append_code($text . $this->_get_space(), false);
          break;

        case T_ELSEIF:
          $space_after  = $this->options["SPACE_AFTER_IF"];
          $added_braces = $this->_is_token(S_SEMI_COLON, true) && $this->options["ADD_MISSING_BRACES"];
          $condition    = $this->options['ELSE_ALONG_CURLY'] && ($this->_is_token(S_CLOSE_CURLY, true) || $added_braces);
          $this->_append_code($this->_get_space($condition) . $text . $this->_get_space($space_after), $condition);
          $if_level++;
          $if_parenth["i" . $if_level] = 0;
          break;

        case T_ELSE:
          $added_braces = $this->_is_token(S_SEMI_COLON, true) && $this->options["ADD_MISSING_BRACES"];
          $condition = $this->options['ELSE_ALONG_CURLY'] && ($this->_is_token(S_CLOSE_CURLY, true) || $added_braces);
          $this->_append_code($this->_get_space($condition) . $text, $condition);
          if (!$this->_is_token(S_OPEN_CURLY) && !$this->_is_token(array(T_IF))) {
            $text = $this->options["ADD_MISSING_BRACES"] ? "{" : "";
            $this->_set_indent( + 1);
            $this->_append_code((!$this->options["LINE_BEFORE_CURLY"] || $text == "" ? ' ' : $this->_get_crlf_indent(false, - 1)) . $text . $this->_get_crlf_indent());
            $if_pending++;
          }
          break;

        default:
          $this->_append_code($text . ' ', false);
          break;
      }
    }
    return $this->_align_operators();
  }

  function _get_token($token)
  {
    if (is_string($token)) {
      return array($token, $token);
    }
    else {
      return $token;
    }
  }

  function _append_code($code = "", $trim = true)
  {
    if ($trim) {
      $this->_code = rtrim($this->_code) . $code;
    }
    else {
      $this->_code .= $code;
    }
  }

  function _get_crlf_indent($in_for = false, $increment = 0)
  {
    if ($in_for) {
      $this->_for_idx++;
      if ($this->_for_idx > 2) {
        $this->_for_idx = 0;
      }
    }
    if ($this->_for_idx == 0 || !$in_for) {
      return $this->_get_crlf() . $this->_get_indent($increment);
    }
    else {
      return $this->_get_space($this->options["SPACE_INSIDE_FOR"]);
    }
  }

  function _get_crlf($true = true)
  {
    return $true ? $this->_new_line : "";
  }

  function _get_space($true = true)
  {
    return $true ? " " : "";
  }

  function _get_indent($increment = 0)
  {
    return str_repeat($this->indent_char, ($this->_indent + $increment) * $this->indent_size);
  }

  function _set_indent($increment)
  {
    $this->_indent += $increment;
    if ($this->_indent < 0) {
      $this->_indent = 0;
    }
  }

  function _is_token($token, $prev = false, $i = 99999, $idx = false)
  {
    if ($i == 99999) {
      $i = $this->_pointer;
    }
    if ($prev) {
      while (--$i >= 0 && is_array($this->_tokens[$i]) && $this->_tokens[$i][0] == T_WHITESPACE);
    }
    else {
      while (++$i < count($this->_tokens)-1 && is_array($this->_tokens[$i]) && $this->_tokens[$i][0] == T_WHITESPACE);
    }
    if (isset($this->_tokens[$i]) && is_string($this->_tokens[$i]) && $this->_tokens[$i] == $token) {
      return $idx ? $i : true;
    }
    elseif (is_array($token) && is_array($this->_tokens[$i])) {
      if (in_array($this->_tokens[$i][0], $token)) {
        return $idx ? $i : true;
      }
      elseif ($prev && $this->_tokens[$i][0] == T_OPEN_TAG) {
        return $idx ? $i : true;
      }
    }
    return false;
  }

  function _is_token_lf($prev = false, $i = 99999)
  {
    if ($i == 99999) {
      $i = $this->_pointer;
    }
    if ($prev) {
      $count = 0;
      while (--$i >= 0 && is_array($this->_tokens[$i]) && $this->_tokens[$i][0] == T_WHITESPACE && strpos($this->_tokens[$i][1], "\n") === false);
    }
    else {
      $count = 1;
      while (++$i < count($this->_tokens) && is_array($this->_tokens[$i]) && $this->_tokens[$i][0] == T_WHITESPACE && strpos($this->_tokens[$i][1], "\n") === false);
    }
    if (is_array($this->_tokens[$i]) && preg_match_all("/\r?\n/", $this->_tokens[$i][1], $matches) > $count) {
      return true;
    }
    return false;
  }

  function _pad_operators($found)
  {
    global $quotes;
    $pad_size = 0;
    $result   = "";
    $source   = explode($this->_new_line, $found[0]);
    $position = array();
    array_pop($source);
    foreach ($source as $k => $line) {
      if (preg_match("/'quote[0-9]+'/", $line)) {
        preg_match_all("/'quote([0-9]+)'/", $line, $holders);
        for ($i = 0; $i < count($holders[1]); $i++) {
          $line = preg_replace("/" . $holders[0][$i] . "/", str_repeat(" ", strlen($quotes[0][$holders[1][$i]])), $line);
        }
      }
      if (strpos($line, "=") > $pad_size) {
        $pad_size = strpos($line, "=");
      }
      $position[$k] = strpos($line, "=");
    }
    foreach ($source as $k => $line) {
      $padding = str_repeat(" ", $pad_size - $position[$k]);
      $padded  = preg_replace("/^([^=]+?)([\.\+\*\/\-\%]?=)(.*)$/", "\\1{$padding}\\2\\3" . $this->_new_line, $line);
      $result .= $padded;
    }
    return $result;
  }

  function _parse_block($blocks)
  {
    global $quotes;
    $pad_chars = "";
    $holders = array();
    if ($this->options['ALIGN_ARRAY_ASSIGNMENT']) {
      $pad_chars .= ",";
    }
    if ($this->options['ALIGN_VAR_ASSIGNMENT']) {
      $pad_chars .= ";";
    }
    $php_code = $blocks[0];
    preg_match_all("/\/\*.*?\*\/|\/\/[^\n]*|#[^\n]|([\"'])[^\\\\]*?(?:\\\\.[^\\\\]*?)*?\\1/s", $php_code, $quotes);
    $quotes[0] = array_values(array_unique($quotes[0]));
    for ($i = 0; $i < count($quotes[0]); $i++) {
      $patterns[]    = "/" . preg_quote($quotes[0][$i], '/') . "/";
      $holders[]     = "'quote$i'";
      $quotes[0][$i] = str_replace('\\\\', '\\\\\\\\', $quotes[0][$i]);
    }
    if (count($holders) > 0) {
      $php_code = preg_replace($patterns, $holders, $php_code);
    }
    $php_code = preg_replace_callback("/(?:.+=.+[" . $pad_chars . "]\r?\n){" . $this->block_size . ",}/", array($this, "_pad_operators"), $php_code);
    for ($i = count($holders) - 1; $i >= 0; $i--) {
      $holders[$i] = "/" . $holders[$i] . "/";
    }
    if (count($holders) > 0) {
      $php_code = preg_replace($holders, $quotes[0], $php_code);
    }
    return $php_code;
  }

  function _align_operators()
  {
    if ($this->options['ALIGN_ARRAY_ASSIGNMENT'] || $this->options['ALIGN_VAR_ASSIGNMENT']) {
      return preg_replace_callback("/<\?.*?\?" . ">/s", array($this, "_parse_block"), $this->_code);
    }
    else {
      return $this->_code;
    }
  }
}
