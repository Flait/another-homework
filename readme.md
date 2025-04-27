
# Geomat Test Project

Jednoduchá PHP aplikace vytvořená jako testovací zadání pro správu produktů přes REST API.

## Použité technologie

- PHP 8.3
- Nette Framework
- PostgreSQL 15
- Docker & Docker Compose
- PHPStan (statická analýza kódu)
- PHP-CS-Fixer (formátování kódu podle PSR-12)

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

## Analýza kódu a formátování

### Statická analýza pomocí PHPStan

Spuštění PHPStan analýzy:

```bash
docker-compose run --rm phpstan analyse
```

Tím ověříte kvalitu a správnost kódu.

---

### Automatické formátování kódu pomocí PHP-CS-Fixer

Spuštění PHP-CS-Fixeru:

```bash
vendor/bin/php-cs-fixer fix --allow-risky=yes
```

Tím automaticky upravíte kód podle standardu [PSR-12](https://www.php-fig.org/psr/psr-12/) a přidáte další doporučené úpravy.

---