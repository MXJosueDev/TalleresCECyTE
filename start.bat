@echo off
setlocal enabledelayedexpansion

for /f "tokens=1,2 delims==" %%a in (.env.docker) do (
    set %%a=%%b
    setx %%a "%%b"
)

set args=%*
docker compose up %args% 
endlocal
