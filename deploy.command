#!/usr/bin/env bash
set -x
echo ">>> Deploy iniciado em $(date)"

HOST="ftp.pravoce.io"
USER="deploy@pravoce.io"
PASS="zje5nzd.jpv-acj4PVK"

LOCAL_DIR="/Applications/XAMPP/xamppfiles/htdocs/InsightSuite/app"
REMOTE_DIR="/"

lftp -u "$USER","$PASS" "$HOST" <<EOF
  debug 3
  set ftp:ssl-allow no

  # 1) Config — só routes.php
  mirror --reverse --delete --verbose \
         --no-recursion \
         --include-glob "Routes.php" \
         "$LOCAL_DIR/Config" \
         "$REMOTE_DIR/Config"

  # 2) Controllers — só .php em qualquer subpasta
  mirror --reverse --delete --verbose \
         --include-glob "*/" \
         --include-glob "*.php" \
         "$LOCAL_DIR/Controllers" \
         "$REMOTE_DIR/Controllers"

  # 3) Helpers — só .php em qualquer subpasta
  mirror --reverse --delete --verbose \
         --include-glob "*/" \
         --include-glob "*.php" \
         "$LOCAL_DIR/Helpers" \
         "$REMOTE_DIR/Helpers"

  # 4) Libraries — só .php em qualquer subpasta
  mirror --reverse --delete --verbose \
         --include-glob "*/" \
         --include-glob "*.php" \
         "$LOCAL_DIR/Libraries" \
         "$REMOTE_DIR/Libraries"

  # 5) Models — só .php na raiz (sem entrar em subpastas)
  mirror --reverse --delete --verbose \
         --no-recursion \
         --include-glob "*.php" \
         "$LOCAL_DIR/Models" \
         "$REMOTE_DIR/Models"

  # 6) Views — só .php em qualquer subpasta
  mirror --reverse --delete --verbose \
         --include-glob "*/" \
         --include-glob "*.php" \
         "$LOCAL_DIR/Views" \
         "$REMOTE_DIR/Views"

  bye
EOF

echo ">>> Deploy concluído em $(date)."
read -n1 -rsp $'Pressione qualquer tecla para fechar...\n'