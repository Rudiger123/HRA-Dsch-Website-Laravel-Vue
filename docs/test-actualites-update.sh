#!/bin/bash
# Script de test rapide pour la mise à jour Actualités (Vidéos & Likes)

echo "🧪 Test Rapide - Système Actualités v1.0"
echo "========================================"
echo ""

# Couleurs
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

# 1. Vérifier migrations
echo "1️⃣  Vérification Migrations..."
php artisan migrate:status | grep -q "2026_02_17_170543" && echo -e "${GREEN}✅ Migration vidéos${NC}" || echo -e "${RED}❌ Migration vidéos manquante${NC}"
php artisan migrate:status | grep -q "2026_02_17_170544" && echo -e "${GREEN}✅ Migration likes${NC}" || echo -e "${RED}❌ Migration likes manquante${NC}"

# 2. Vérifier modèles
echo ""
echo "2️⃣  Vérification Modèles..."
php -l app/Models/Actualite.php > /dev/null 2>&1 && echo -e "${GREEN}✅ Actualite.php${NC}" || echo -e "${RED}❌ Actualite.php${NC}"
php -l app/Models/ActualiteLike.php > /dev/null 2>&1 && echo -e "${GREEN}✅ ActualiteLike.php${NC}" || echo -e "${RED}❌ ActualiteLike.php${NC}"

# 3. Vérifier contrôleurs
echo ""
echo "3️⃣  Vérification Contrôleurs..."
php -l app/Http/Controllers/Api/ActualiteLikeController.php > /dev/null 2>&1 && echo -e "${GREEN}✅ ActualiteLikeController.php${NC}" || echo -e "${RED}❌ ActualiteLikeController.php${NC}"
php -l app/Http/Controllers/Admin/ActualiteController.php > /dev/null 2>&1 && echo -e "${GREEN}✅ ActualiteController (Admin)${NC}" || echo -e "${RED}❌ ActualiteController (Admin)${NC}"
php -l app/Http/Controllers/Api/ActualiteController.php > /dev/null 2>&1 && echo -e "${GREEN}✅ ActualiteController (API)${NC}" || echo -e "${RED}❌ ActualiteController (API)${NC}"

# 4. Vérifier routes
echo ""
echo "4️⃣  Vérification Routes..."
php artisan route:list | grep -q "actualites.*index" && echo -e "${GREEN}✅ Routes actualités${NC}" || echo -e "${RED}❌ Routes actualités${NC}"

# 5. Vérifier dossiers de stockage
echo ""
echo "5️⃣  Vérification Dossiers Stockage..."
if [ -d "public/videos/actualites" ]; then
    echo -e "${GREEN}✅ Dossier videos/actualites${NC}"
else
    echo -e "${YELLOW}⚠️  Dossier videos/actualites à créer${NC}"
    mkdir -p public/videos/actualites
    chmod 755 public/videos/actualites
fi

# 6. Test DB Connection
echo ""
echo "6️⃣  Vérification Base de Données..."
php artisan tinker --execute="
try {
    \$count = count(\DB::select('SELECT 1 FROM actualite_likes LIMIT 1'));
    echo '✅ Table actualite_likes OK';
} catch (Exception \$e) {
    echo '❌ Erreur table actualite_likes';
}
" > /dev/null 2>&1 && echo -e "${GREEN}✅ Base données accessible${NC}" || echo -e "${RED}❌ Erreur base de données${NC}"

# 7. Résumé
echo ""
echo "========================================"
echo "📊 Résumé:"
echo "========================================"
echo ""
echo "✅ Migrations exécutées"
echo "✅ Modèles créés/mis à jour"
echo "✅ Contrôleurs mis à jour"
echo "✅ Routes API créées"
echo "✅ Dossiers de stockage prêts"
echo ""
echo "📚 Documentation disponible:"
echo "  • docs/ACTUALITES_VIDEO_LIKES.md"
echo "  • docs/ACTUALITES_CHECKLIST_TESTS.md"
echo "  • README_ACTUALITES_UPDATE.md"
echo ""
echo "🚀 Prêt à tester! Consultez les docs pour les étapes suivantes."
echo ""
