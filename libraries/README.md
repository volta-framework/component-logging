
- For the (UML)Domain model see [the README in the main folder](./../README.md)
- To see the loggers in action see [the README in the public folder](./../public/README.md)
- For more details see [the README in the libraries folder](./README.md)

# Volta\Component\Logging

This component is based on the Psr\Log Interfaces. For more information about these interfaces see https://www.php-fig.org/psr/psr-3/.

We added the functionality to choose which log levels should be added to the log. If no levels are specified all the levels are logged. When the list with levels is set with `BaseLogger->setLevels()` only the levels present in this list will be logged.

Example:
```php

$logger = new \Volta\Component\Logging\ConsoleLogger(['Debug', 'Critical']);
$logger->warning('This will NOT be logged.');
$logger->debug('But this will');

$logger = new \Volta\Component\Logging\FileLogger('path-to-log-file.log');
$logger->setLevels(['Debug', 'Critical']);
$logger->warning('This will NOT be logged.');
$logger->debug('But this will');

```

 
The Logging component counts 5 classes all in the namespace *Volta\Component\Logging*:

1. Volta\Component\Logging\BaseLogger
2. Volta\Component\Logging\ConsoleLogger
3. Volta\Component\Logging\FileLogger
4. Volta\Component\Logging\PassThroughLogger
5. Volta\Component\Logging\Exception

## ~\ConsoleLogger

The Console logger will send the log entries to the console if available. This means if the constant **STDOUT** is available. When we are running the PHP build in webserver, we send the log entry to the **error_log** which in turn is printed to the console. In all other cases, the entry is ignored. Mostly used for debugging.

```mermaid
classDiagram
    direction LR
    class Psr_Log_LoggerInterFace{ <<interface>> }
    class ConsoleLogger {+__construct(string[] $levels)}
    class Psr_Log_LoggerTrait { <<trait>> }
    class BaseLogger {
        +setLevels(string[])
        +getLevels():string[]
        +hasLevel(string):bool
    }

    style Psr_Log_LoggerTrait opacity: 0.2 
    style Psr_Log_LoggerInterFace opacity: 0.2  
    style ConsoleLogger stroke:#FFa500 

    BaseLogger ..|> Psr_Log_LoggerInterFace : implements
    BaseLogger o-- Psr_Log_LoggerTrait : uses
    ConsoleLogger <|--  BaseLogger : Extends
```

## ~\FileLogger

The File logger will append the log entries to a file. The file is set when the Log is instantiated. An exception is thrown when the file is invalid.

```mermaid
classDiagram
    direction LR
    
    class Psr_Log_LoggerInterFace{ <<interface>> }
    class FileLogger { +__construct(string $path, bool $create=true)}
    class Psr_Log_LoggerTrait { <<trait>> }
    class Exception
    class BaseLogger

    style Psr_Log_LoggerTrait opacity: 0.2 
    style Psr_Log_LoggerInterFace opacity: 0.2 
    style FileLogger stroke:#FFa500 

    BaseLogger ..|> Psr_Log_LoggerInterFace : implements
    BaseLogger o-- Psr_Log_LoggerTrait : uses
    FileLogger .. Exception : throws
    FileLogger <|--  BaseLogger : Extends    
```

## ~\PassThroughLogger

This Logger will pass the log entry to the given (valid)callback. The callback is set when the Log is instantiated. Throw an Exception when an invalid callback is passed. 

```mermaid
classDiagram
    direction LR
    
    class Psr_Log_LoggerInterFace{ <<interface>> }
    class PassThroughLogger { +__construct(callable $callback) }
    class Psr_Log_LoggerTrait { <<trait>> }
    class Exception
    class BaseLogger

    style Psr_Log_LoggerTrait opacity: 0.2 
    style Psr_Log_LoggerInterFace opacity: 0.2 
    style PassThroughLogger stroke:#FFa500
    
    BaseLogger ..|> Psr_Log_LoggerInterFace : implements
    BaseLogger o-- Psr_Log_LoggerTrait : uses
    PassThroughLogger .. Exception : throws
    PassThroughLogger <|--  BaseLogger : Extends
```

## ~\Exception

Basic Exception for all exceptions thrown in this Component.

```mermaid
classDiagram
    direction TB
    
    class Exception
    class Std_Exception
    class Stringable { <<interface>> }
    class Throwable { <<interface>> }
    
    style Std_Exception opacity: 0.2 
    style Stringable opacity: 0.2
    style Throwable opacity: 0.2 
    style Exception stroke:#FFa500
    
    Std_Exception  <|-- Exception : extends
    Stringable ..|> Throwable : implements
    Throwable  ..|> Std_Exception : implements
```