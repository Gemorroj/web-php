<?php
$_SERVER['BASE_PAGE'] = 'php8.php';
include_once __DIR__ . '/include/prepend.inc';

site_header("PHP 8", array("current" => "php8", 'css' => array('php8.css')));
?>
<section class="php8-section php8-section_dark php8-section_header center">
  <div class="php8-section__content">
    <div class="php8-logo">
      <img src="/images/php8/logo_php8.svg" alt="php8" height="126" width="343">
    </div>
    <div class="php8-title">
      <span class="php8-title__text">released!</span>
      <img class="php8-title__img" src="/images/php8/party-popper.png" srcset="/images/php8/party-popper@2x.png 2x, /images/php8/party-popper@2x.pngx.png 3x" alt="" width="58" height="58">
    </div>
    <div class="php8-subtitle">
      PHP 8.0 is a major update of the PHP language. It contains many new features and optimizations. Including named
      arguments, union types, attributes, constructor property promotion, match expression, nullsafe operator, JIT, and
      improvements in type system, error handling, and consistency.
    </div>
  </div>
</section>

<section class="php8-section center">
  <div class="php8-compare">
    <h2 class="php8-h2" id="named-arguments">
      Named arguments
      <a class="php8-rfc" href="https://wiki.php.net/rfc/named_params">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
          <pre>htmlspecialchars($string, ENT_COMPAT | ENT_HTML401, 'UTF-8', false);</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
          <pre>htmlspecialchars($string, double_encode: false);</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="php8-compare">
    <h2 class="php8-h2" id="attributes">
      Attributes
      <a class="php8-rfc" href="https://wiki.php.net/rfc/attributes_v2">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
<pre>/**
* @Route("/api/posts/{id}", methods={"GET", "HEAD"})
*/
classUser
{</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
<pre>#[Route("/api/posts/{id}", methods: ["GET", "HEAD"])]
class User
{</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="php8-compare">
    <h2 class="php8-h2" id="constructor-property-promotion">
      Constructor property promotion
      <a class="php8-rfc" href="https://wiki.php.net/rfc/constructor_promotion">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
<pre>class Point {
 public float $x;
 public float $y;
 public float $z;

 public function __construct(
     float $x = 0.0,
     float $y = 0.0,
     float $z = 0.0,
 ) {
     $this->x = $x;
     $this->y = $y;
     $this->z = $z;
 }
}</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
<pre>class Point {
 public function __construct(
     public float $x = 0.0,
     public float $y = 0.0,
     public float $z = 0.0,
 ) {}
}</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="php8-compare">
    <h2 class="php8-h2" id="union-types">
      Union types
      <a class="php8-rfc" href="https://wiki.php.net/rfc/union_types_v2">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
<pre>class Number {
 /** @var int|float */
 private $number;

 /**
  * @param float|int $number
  */
 public function __construct($number) {
     $this->number = $number;
 }
}

new Number('NaN'); // Ok</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
<pre>class Number {
 public function __construct(
     private int|float $number
 ) {}
}

new Number('NaN'); // TypeError</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="php8-compare">
    <h2 class="php8-h2" id="match-expression">
      Match expression
      <a class="php8-rfc" href="https://wiki.php.net/rfc/match_expression_v2">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
<pre>switch (8.0) {
 case '8.0':
   $result = "Oh no!";
   break;
 case 8.0:
   $result = "This is what I expected";
   break;
}
echo $result;
//> Oh no!</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
<pre>echo match (8.0) {
 '8.0' => "Oh no!",
 8.0 => "This is what I expected",
};
//> This is what I expected</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="php8-compare">
    <h2 class="php8-h2" id="nullsafe-operator">
      Nullsafe operator
      <a class="php8-rfc" href="https://wiki.php.net/rfc/nullsafe_operator">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
<pre>$country =  null;

if ($session !== null) {
 $user = $session->user;

 if ($user !== null) {
     $address = $user->getAddress();

     if ($address !== null) {
         $country = $address->country;
     }
 }
}</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
          <pre>$country = $session?->user?->getAddress()?->country;</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="php8-compare">
    <h2 class="php8-h2" id="saner-string-to-number-comparisons">
      Saner string to number comparisons
      <a class="php8-rfc" href="https://wiki.php.net/rfc/string_to_number_comparison">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
          <pre>0 == 'foobar' // true</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
          <pre>0 == 'foobar' // false</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="php8-compare">
    <h2 class="php8-h2" id="consistent-type-errors-for-internal-functions">
      Consistent type errors for internal functions
      <a class="php8-rfc" href="https://wiki.php.net/rfc/consistent_type_errors">RFC</a>
    </h2>
    <div class="php8-compare__main">
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label">PHP 7</div>
        <div class="php8-code phpcode">
<pre>\t\t strlen([]); // Warning: strlen() expects parameter 1 to be string, array given

array_chunk([], -1); // Warning: array_chunk(): Size parameter expected to be greater than 0</pre>
        </div>
      </div>
      <div class="php8-compare__arrow"></div>
      <div class="php8-compare__block example-contents">
        <div class="php8-compare__label php8-compare__label_new">PHP 8</div>
        <div class="php8-code phpcode">
<pre>strlen([]); // TypeError: strlen(): Argument #1 ($str) must be of type string, array given

array_chunk([], -1); // ValueError: array_chunk(): Argument #2 ($length) must be greater than 0</pre>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="php8-section php8-section_light">
  <h2 class="php8-h2">Just-In-Time compilation</h2>
  <p>
    PHP 8 introduces two JIT compilation engines. The more promising, tracing JIT shows about 3 times speed-up on
    synthetic benchmarks and 1.5-2 times improvement on some specific long-running apps. Typical apps performance is on
    par with PHP 7.4.
  </p>
  <p>
    <img src="/images/php8/jit.png" alt="Just-In-Time compilation">
  </p>

  <h2 class="php8-h2 php8-h2_margin-top">Other syntax tweaks and improvements</h2>
  <div class="php8-columns">
    <div class="php8-column">
      <ul>
        <li>
          Allow trailing comma in parameter list <a href="https://wiki.php.net/rfc/trailing_comma_in_parameter_list">RFC</a>
          and closure use lists <a href="https://wiki.php.net/rfc/trailing_comma_in_closure_use_list">RFC</a>
        </li>
        <li>
          Non-capturing catches <a href="http://TODO">RFC</a>
        </li>
        <li>
          Variable Syntax Tweaks <a href="https://wiki.php.net/rfc/variable_syntax_tweaks">RFC</a>
        </li>
      </ul>
    </div>
    <div class="php8-column">
      <ul>
        <li>
          Treat namespaced names as single token <a href="https://wiki.php.net/rfc/namespaced_names_as_token">RFC</a>
        </li>
        <li>
          Throw expression <a href="https://wiki.php.net/rfc/throw_expression">RFC</a>
        </li>
        <li>
          Allow ::class on objects <a href="https://wiki.php.net/rfc/class_name_literal_on_object">RFC</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="php8-columns">
    <div class="php8-column">
      <h2 class="php8-h2 php8-h2_margin-top">Type system and error handling improvements</h2>
      <ul>
        <li>
          Saner string to number comparisons <a href="https://wiki.php.net/rfc/string_to_number_comparison">RFC</a>
        </li>
        <li>
          Stricter type checks for arithmetic/bitwise operators
          <a href="https://wiki.php.net/rfc/arithmetic_operator_type_checks">RFC</a>
        </li>
        <li>
          Abstract trait method validation <a href="http://TODO">RFC</a>
        </li>
        <li>
          Correct signatures of magic methods <a href="https://wiki.php.net/rfc/magic-methods-signature">RFC</a>
        </li>
        <li>
          Reclassified engine warnings <a href="https://wiki.php.net/rfc/engine_warnings">RFC</a>
        </li>
        <li>
          Fatal error for incompatible method signatures <a href="https://wiki.php.net/rfc/lsp_errors">RFC</a>
        </li>
        <li>
          The @ operator no longer silences fatal errors
        </li>
        <li>
          Inheritance with private methods <a href="https://wiki.php.net/rfc/inheritance_private_methods">RFC</a>
        </li>
        <li>
          Mixed type <a href="https://wiki.php.net/rfc/mixed_type_v2">RFC</a>
        </li>
        <li>
          Static return type <a href="">RFC</a>
        </li>
        <li>
          Types for internal functions
          <a href="https://externals.io/message/106522">RFC</a>
        </li>
        <li>
          Curl objects instead of resources
          <a href="https://php.watch/versions/8.0/resource-CurlHandle">RFC</a>
        </li>
      </ul>
    </div>
    <div class="php8-column">
      <h2 class="php8-h2 php8-h2_margin-top">New Classes, Interfaces, and Functions</h2>
      <ul>
        <li>
          <a href="https://wiki.php.net/rfc/weak_maps">Weak Map</a> class
        </li>
        <li>
          <a href="https://wiki.php.net/rfc/stringable">Stringable</a> interface
        </li>
        <li>
          <a href="https://wiki.php.net/rfc/str_contains">str_contains()</a>,
          <a href="https://wiki.php.net/rfc/add_str_starts_with_and_ends_with_functions">str_starts_with()</a>,
          <a href="https://wiki.php.net/rfc/add_str_starts_with_and_ends_with_functions">str_ends_with()</a>
        </li>
        <li>
          <a href="https://github.com/php/php-src/pull/4769">fdiv()</a>
        </li>
        <li>
          <a href="https://wiki.php.net/rfc/get_debug_type">get_debug_type()</a>
        </li>
        <li>
          <a href="https://github.com/php/php-src/pull/5427">get_resource_id()</a>
        </li>
        <li>
          <a href="https://wiki.php.net/rfc/token_as_object">token_get_all()</a> object implementation
        </li>
      </ul>
    </div>
  </div>
</section>

<section class="php8-section php8-section_dark php8-section_footer php8-footer">
  <div class="php8-section__content">
    <h2 class="php8-h2 center">
      Get free performance improvement.<br class="display-none-lg display-block-md">
      Get better syntax.<br class="display-block-lg display-none-md display-block-sm">
      Get more strictness.
    </h2>
    <div class="php8-button-wrapper center">
      <a class="php8-button php8-button_light" href="#">Go update to PHP 8!</a>
    </div>
    <div class="php8-footer__content">
      <p>
        For source downloads of PHP 8 please visit our <a href="http://www.php.net/downloads">downloads</a> page.
        Windows binaries can be found on the <a href="http://windows.php.net/download">PHP for Windows</a> site.
        The list of changes is recorded in the <a href="http://www.php.net/ChangeLog-8.php">ChangeLog</a>.
      </p>
      <p>
        The <a href="http://php.net/manual/en/migration8.php">migration guide</a> is available in the PHP Manual. Please
        consult it for the detailed list of new features and backward-incompatible changes.
      </p>
    </div>
  </div>
</section>




<?php site_footer();