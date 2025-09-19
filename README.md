# Colin - Simple Kanban Boards

Colin is a lightweight Kanban board application built with:
- PHP (Flight micro-framework) for a minimal API + server-rendered entry points
- A custom Web Components + Reef (signals) frontend for interactive columns and cards
- MySQL for persistence (schema and sample data included under /sql)

Current goals:
- Provide a clean, minimal core for creating boards, columns, and cards
- Keep the backend simple and transparent (no heavy ORM)
- Enable easy extension (actions are small invokable classes)

Status:
The project is under active development.

Quick start:
1. Copy config/config.php.dist to config/config.php and adjust DB credentials
2. Apply SQL files in /sql (01 -> 03, then optionally 11 for sample data)
3. Run: composer install
4. Start dev server: composer run serve
5. Visit: http://localhost:8001/board/{your-board-uuid}

License: MIT (see LICENSE.md)

For deeper architectural notes see AGENT.md.
