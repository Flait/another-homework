
# Geomat Test Project

Jednoduchá PHP aplikace vytvořená jako testovací zadání pro správu produktů přes REST API.

## Použité technologie

- PHP 8.3
- Nette Framework
- PostgreSQL 15
- Docker & Docker Compose

## Požadavky

- Docker
- Docker Compose
- Git

## Instalace a spuštění

1. Naklonujte repozitář:

```bash
git clone https://github.com/your-username/geomat-test-project.git
cd geomat-test-project
```

2. Vytvořte `.env` soubor z předpřipraveného `.env.local`:

```bash
cp .env.local .env
```

3. Spusťte Docker Compose:

```bash
docker-compose up -d
```

4. Aplikace bude dostupná na:

```
http://localhost:8000
```
