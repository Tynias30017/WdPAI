#!/bin/bash

# Adres URL aplikacji pod którym działa serwer w Dockerze
BASE_URL="http://localhost:8080"

echo "=== ROZPOCZĘCIE TESTÓW INTEGRACYJNYCH ENDPOINTÓW ==="
echo "Adres bazowy: $BASE_URL"
echo ""

# Funkcja pomocnicza do sprawdzania kodów HTTP odpowiedzi
check_status() {
    local url=$1
    local expected_status=$2
    local label=$3

    status_code=$(curl -s -o /dev/null -w "%{http_code}" "$url")

    if [ "$status_code" -eq "$expected_status" ]; then
        echo -e "\e[32m[PASS]\e[0m $label ($url) - Oczekiwano $expected_status, otrzymano $status_code"
    else
        echo -e "\e[31m[FAIL]\e[0m $label ($url) - Oczekiwano $expected_status, ale otrzymano $status_code"
        exit 1
    fi
}

# 1. Strona główna
check_status "$BASE_URL/" 200 "Strona Główna"

# 2. Strona logowania
check_status "$BASE_URL/login" 200 "Strona Logowania"

# 3. Strona rejestracji
check_status "$BASE_URL/register" 200 "Strona Rejestracji"

# 4. Dostęp do chronionej trasy bez autoryzacji (Powinno przekierować na logowanie - kod 302)
check_status "$BASE_URL/workouts" 302 "Chroniona trasa /workouts (Brak autoryzacji -> Przekierowanie)"

# 5. Dostęp do panelu administratora bez autoryzacji (Powinno przekierować na logowanie - kod 302)
check_status "$BASE_URL/admin/users" 302 "Chroniona trasa /admin/users (Brak autoryzacji -> Przekierowanie)"

# 6. Dostęp do bazy ćwiczeń bez autoryzacji (Powinno przekierować na logowanie - kod 302)
check_status "$BASE_URL/exercises" 302 "Chroniona trasa /exercises (Brak autoryzacji -> Przekierowanie)"

# 7. Nieistniejący zasób (Globalny router powinien zgłosić kod 404)
check_status "$BASE_URL/non-existent-endpoint-test" 404 "Nieistniejący zasób (Strona błędu 404)"

echo ""
echo -e "\e[32m=== WSZYSTKIE TESTY INTEGRACYJNE ZAKOŃCZONE SUKCESEM ===\e[0m"
exit 0
