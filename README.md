[//]: # (Start Quadro\UmlDoc\MermaidDiagram)
```mermaid
classDiagram
    class Volta_Component_Logging_ConsoleLogger {
        +alert(Stringable|string message, array context=[]):void
        +critical(Stringable|string message, array context=[]):void
        +debug(Stringable|string message, array context=[]):void
        +emergency(Stringable|string message, array context=[]):void
        +error(Stringable|string message, array context=[]):void
        +info(Stringable|string message, array context=[]):void
        +log( level, Stringable|string message, array context=[]):void
        +notice(Stringable|string message, array context=[]):void
        +warning(Stringable|string message, array context=[]):void
    }
    class Psr_Log_LoggerInterface {
         	&lt;&lt;interface&gt;&gt;
    }
    Psr_Log_LoggerInterface..|>Volta_Component_Logging_ConsoleLogger
    Volta_Component_Logging_ConsoleLogger..>Psr_Log_LoggerTrait
    class Volta_Component_Logging_Exception
    Exception<|--Volta_Component_Logging_Exception
    class Exception
    class Stringable {
         	&lt;&lt;interface&gt;&gt;
    }
    class Throwable {
         	&lt;&lt;interface&gt;&gt;
    }
    Stringable..|>Throwable
    Throwable..|>Exception
    class Volta_Component_Logging_FileLogger {
        +__construct(string path, bool create=true)
        +__destruct()
        +alert(Stringable|string message, array context=[]):void
        +critical(Stringable|string message, array context=[]):void
        +debug(Stringable|string message, array context=[]):void
        +emergency(Stringable|string message, array context=[]):void
        +error(Stringable|string message, array context=[]):void
        +info(Stringable|string message, array context=[]):void
        +log( level, Stringable|string message, array context=[]):void
        +notice(Stringable|string message, array context=[]):void
        +warning(Stringable|string message, array context=[]):void
    }
    Psr_Log_LoggerInterface..|>Volta_Component_Logging_FileLogger
    Volta_Component_Logging_FileLogger..>Psr_Log_LoggerTrait
    class Volta_Component_Logging_PassthroughLogger {
        +__construct(mixed callback)
        +alert(Stringable|string message, array context=[]):void
        +critical(Stringable|string message, array context=[]):void
        +debug(Stringable|string message, array context=[]):void
        +emergency(Stringable|string message, array context=[]):void
        +error(Stringable|string message, array context=[]):void
        +info(Stringable|string message, array context=[]):void
        +log( level, Stringable|string message, array context=[]):void
        +notice(Stringable|string message, array context=[]):void
        +warning(Stringable|string message, array context=[]):void
    }
    Psr_Log_LoggerInterface..|>Volta_Component_Logging_PassthroughLogger
    Volta_Component_Logging_PassthroughLogger..>Psr_Log_LoggerTrait
```
[//]: # (End Quadro\UmlDoc\MermaidDiagram)
[//]: # (Start Quadro\UmlDoc\MdDiagram)

Generated @  20230619 13:50:49

# Volta\Component\Logging\
4 Classes, 0 Interfaces, 0 Traits, 0 Enums,
### [Volta\Component\Logging\ConsoleLogger](#) *implements* Psr\Log\LoggerInterface
 The Console logger will send the log entries to the console if available. This means if STDOUT is available of
 when we are running the PHP build in webserver. In the latter case we send the log entry to the error_log which
 is printed to the console. In all other cases the entry is ignored
#### Methods(9)
- public function **[alert](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Action must be taken immediately.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Entire website down, database unavailable, etc. This should*\
&nbsp;&nbsp; *trigger the SMS alerts and wake you up.*
- public function **[critical](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Critical conditions.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Application component unavailable, unexpected exception.*
- public function **[debug](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Detailed debug information.*
- public function **[emergency](#)(Stringable|string message, array context=[])**: void\
&rdsh; *System is unusable.*
- public function **[error](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Runtime errors that do not require immediate action but should typically*\
&nbsp;&nbsp; *be logged and monitored.*
- public function **[info](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Interesting events.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: User logs in, SQL logs.*
- public function **[log](#)( level, Stringable|string message, array context=[])**: void\
&rdsh; *The log entries are made colorfully before send to the console.*
- public function **[notice](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Normal but significant events.*
- public function **[warning](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Exceptional occurrences that are not errors.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Use of deprecated APIs, poor use of an API, undesirable things*\
&nbsp;&nbsp; *that are not necessarily wrong.*
### [Volta\Component\Logging\Exception](#) : Exception *implements* Throwable, Stringable
### [Volta\Component\Logging\FileLogger](#) *implements* Psr\Log\LoggerInterface
#### Methods(11)
- public function **[__construct](#)(string path, bool create=true)**:
- public function **[__destruct](#)()**:
- public function **[alert](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Action must be taken immediately.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Entire website down, database unavailable, etc. This should*\
&nbsp;&nbsp; *trigger the SMS alerts and wake you up.*
- public function **[critical](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Critical conditions.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Application component unavailable, unexpected exception.*
- public function **[debug](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Detailed debug information.*
- public function **[emergency](#)(Stringable|string message, array context=[])**: void\
&rdsh; *System is unusable.*
- public function **[error](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Runtime errors that do not require immediate action but should typically*\
&nbsp;&nbsp; *be logged and monitored.*
- public function **[info](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Interesting events.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: User logs in, SQL logs.*
- public function **[log](#)( level, Stringable|string message, array context=[])**: void
- public function **[notice](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Normal but significant events.*
- public function **[warning](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Exceptional occurrences that are not errors.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Use of deprecated APIs, poor use of an API, undesirable things*\
&nbsp;&nbsp; *that are not necessarily wrong.*
### [Volta\Component\Logging\PassthroughLogger](#) *implements* Psr\Log\LoggerInterface
 This Logger will pass the log entry to the given callback
#### Methods(10)
- public function **[__construct](#)(mixed callback)**:
- public function **[alert](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Action must be taken immediately.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Entire website down, database unavailable, etc. This should*\
&nbsp;&nbsp; *trigger the SMS alerts and wake you up.*
- public function **[critical](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Critical conditions.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Application component unavailable, unexpected exception.*
- public function **[debug](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Detailed debug information.*
- public function **[emergency](#)(Stringable|string message, array context=[])**: void\
&rdsh; *System is unusable.*
- public function **[error](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Runtime errors that do not require immediate action but should typically*\
&nbsp;&nbsp; *be logged and monitored.*
- public function **[info](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Interesting events.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: User logs in, SQL logs.*
- public function **[log](#)( level, Stringable|string message, array context=[])**: void\
&rdsh; *The log entries are passed through the callback.*
- public function **[notice](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Normal but significant events.*
- public function **[warning](#)(Stringable|string message, array context=[])**: void\
&rdsh; *Exceptional occurrences that are not errors.*\
&nbsp;&nbsp; \
&nbsp;&nbsp; *Example: Use of deprecated APIs, poor use of an API, undesirable things*\
&nbsp;&nbsp; *that are not necessarily wrong.*

[//]: # (End Quadro\UmlDoc\MdDiagram)
