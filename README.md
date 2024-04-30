- For the (UML)Domain model see [the README in the main folder](./README.md)
- To see the loggers in action see [the README in the public folder](./public/README.md)
- For more details see [the README in the libraries folder](./libraries/README.md)


# Volta Component Logging

Component used for logging information.

The component is based on the Psr\Log Interfaces. For more information about these interfaces see https://www.php-fig.org/psr/psr-3/.

 
```mermaid
classDiagram
    direction BT 
    
    class Spl_Exception
    class Spl_Stringable { <<interface>> }
    class Spl_Throwable { <<interface>> }
    class Psr_Log_LoggerInterface { <<interface>> }
    class Psr_Log_LoggerTrait { <<trait>> }
    class Volta_Component_Logging_Exception 
    class Volta_Component_Logging_BaseLogger {
        +setLevels(string[]):void
        +getLevels():string[]
        +hasLevel(string $level):bool
    }
    class Volta_Component_Logging_ConsoleLogger { 
        +__construct(string[] levels) 
    }  
    class Volta_Component_Logging_FileLogger { 
        +__construct(string path, bool create=true)
        +__destruct()  
    }   
    class Volta_Component_Logging_PassthroughLogger { 
        +__construct(mixed callback)  
    }    
    style Psr_Log_LoggerTrait opacity: 0.2 
    style Psr_Log_LoggerInterface opacity: 0.2  
    style Spl_Throwable opacity: 0.2  
    style Spl_Stringable opacity: 0.2  
    style Spl_Exception opacity: 0.2
    style Volta_Component_Logging_Exception stroke:#FFa500 
    style Volta_Component_Logging_BaseLogger stroke:#FFa500 
    style Volta_Component_Logging_FileLogger stroke:#FFa500 
    style Volta_Component_Logging_ConsoleLogger stroke:#FFa500 
    style Volta_Component_Logging_PassthroughLogger stroke:#FFa500 
 
    Volta_Component_Logging_ConsoleLogger--|>Volta_Component_Logging_BaseLogger: extends
    Volta_Component_Logging_FileLogger--|>Volta_Component_Logging_BaseLogger: extends
    Volta_Component_Logging_PassthroughLogger--|>Volta_Component_Logging_BaseLogger: extends 
    Volta_Component_Logging_BaseLogger<|..Psr_Log_LoggerInterface: implements
    Volta_Component_Logging_BaseLogger<..Psr_Log_LoggerTrait: uses
    Spl_Exception<|--Volta_Component_Logging_Exception: extends
    Spl_Stringable..|>Spl_Throwable: implements
    Spl_Throwable..|>Spl_Exception: implements
    
```  

 