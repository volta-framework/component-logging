# Volta\Component\Logging

Volta Components can not have dependencies other than the PHP standard recommendations and PSR based packages. This component is based on the Psr\Log Interfaces. For more information about these interfaces see https://www.php-fig.org/psr/psr-3/.

The Logging component counts 4 classes all in the namespace *Volta\Component\Logging*:

1. Volta\Component\Logging\ConsoleLogger
2. Volta\Component\Logging\FileLogger
3. Volta\Component\Logging\PassThroughLogger
4. Volta\Component\Logging\Exception

## ~\ConsoleLogger

The Console logger will send the log entries to the console if available. This means if **STDOUT** is available. Or when we are running the PHP build in webserver, we send the log entry to the **error_log** which in turn is printed to the console. In all other cases, the entry is ignored. Mostly used for debugging.

```mermaid
classDiagram
    direction LR
    class Psr_Log_LoggerInterFace{ <<interface>> }
    class ConsoleLogger
    class Psr_Log_LoggerTrait { <<trait>> }
    
    ConsoleLogger ..|> Psr_Log_LoggerInterFace : implements    
    ConsoleLogger o-- Psr_Log_LoggerTrait : uses
```

## ~\FileLogger

The File logger will append the log entries to a file. The file is set when the Log is instantiated. An exception is thrown when the file is invalid.

```mermaid
classDiagram
    direction LR
    class Psr_Log_LoggerInterFace{ <<interface>> }
    class FileLogger { 
        +__construct(string $path, bool $create=true)
    }
    class Psr_Log_LoggerTrait { <<trait>> }
    class Exception
    
    FileLogger ..|> Psr_Log_LoggerInterFace : implements    
    FileLogger o-- Psr_Log_LoggerTrait : uses
    FileLogger .. Exception : throws
    
```

## ~\PassThroughLogger

This Logger will pass the log entry to the given (valid)callback. The callback is set when the Log is instantiated. Throw an Exception when an invalid callback is passed. 

```mermaid
classDiagram
    direction LR
    class Psr_Log_LoggerInterFace{ <<interface>> }
    class PassThroughLogger {
        +__construct(mixed $callback)
    }
    class Psr_Log_LoggerTrait { <<trait>> }
    class Exception

    PassThroughLogger ..|> Psr_Log_LoggerInterFace : implements
    PassThroughLogger o-- Psr_Log_LoggerTrait : uses
    PassThroughLogger .. Exception : throws    
```

## ~\Exception

Basic Exception for all exceptions thrown in this Component.

```mermaid
classDiagram
    direction TB
    class Exception
    class Std_Exception
    class Stringable {
        &lt;&lt;interface&gt;&gt;
    }
    class Throwable {
        &lt;&lt;interface&gt;&gt;
    }
    
    Std_Exception  <|-- Exception : extends
    Stringable ..|> Throwable : implements
    Throwable  ..|> Std_Exception : implements
```