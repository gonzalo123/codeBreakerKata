Kata CodeBreaker

http://www.solveet.com/exercises/Kata-CodeBreaker/14
http://12meses12katas.com/


* Clase: Matcher
 * Se encarga de dar la respuesta a cada intento
* Clase: Code
 * Se encarga de supervisar cada intento. LLevar la cuenta y disparar el evento correspondiente
 * Se le inyecta el Matcher y un EventDispatcher en el constructor
 * Para el EventDispatcher estoy usando el componente de Symfony event-dispatcher
* Randomizer
 * Genera claves aleatorias

Ejemplo de uso:

``` php

use CodeBreaker\Randomizer;
use CodeBreaker\Code;
use CodeBreaker\Matcher;
use Symfony\Component\EventDispatcher\EventDispatcher;


$dispatcher = new EventDispatcher();
$dispatcher->addListener(Code::EVENT_MAX_ATTEMPS, function () {
    echo "Max attempt reached";
});
$dispatcher->addListener(Code::EVENT_CODE_SOLVED, function () {
    echo "Code solvet";
});

$secretCode = Randomizer::generate();
$code = new Code($secretCode, new Matcher(), $dispatcher);

$code->matchTo(['A', 'R', 'N', 'I']);

```