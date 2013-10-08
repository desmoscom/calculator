java -jar compiler.jar --js main.src.js --js_output_file main.js --compilation_level SIMPLE_OPTIMIZATIONS --warning_level QUIET --language_in ECMASCRIPT5 --charset UTF-8
java -jar compiler.jar --js embed.src.js --js_output_file embed.js --compilation_level SIMPLE_OPTIMIZATIONS --warning_level QUIET --language_in ECMASCRIPT5 --charset UTF-8
java -jar compiler.jar --js worker.src.js --js_output_file worker.js --compilation_level SIMPLE_OPTIMIZATIONS --warning_level QUIET --language_in ECMASCRIPT5 --charset UTF-8
pause