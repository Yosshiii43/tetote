<?php
if ( !defined( 'ABSPATH' ) ) exit;


// Contact Form 7で自動挿入されるPタグ、brタグを削除
//add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');

/**
 * Contact Form 7で自動挿入される<p>タグと<br>タグを無効化する関数
 *
 * @return bool false 自動挿入を無効化
 */
//function wpcf7_autop_return_false() {
//  return false;
//}


// メールアドレス一致チェック
add_filter( 'wpcf7_validate_email', 'wpcf7_validate_email_filter_confrim', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_validate_email_filter_confrim', 11, 2 );


// バリデーション
function debug_wpcf7_validate( $result, $tag ) {
  // 早期戻しはせずにまずはログを出す（class 存在チェックは残しておく）
  if ( ! class_exists( 'WPCF7_FormTag' ) ) {
    error_log('[cf7-debug] WPCF7_FormTag class missing');
    return $result;
  }

  // 安全にオブジェクト化
  $tag = new WPCF7_FormTag( $tag );

  // 受け取ったデータをログに出力
  $name  = isset( $tag->name ) ? $tag->name : '(no-name)';
  $type  = isset( $tag->type ) ? $tag->type : '(no-type)';
  $value = isset( $_POST[ $name ] ) ? trim( wp_unslash( strtr( (string) $_POST[ $name ], "\n", " " ) ) ) : '';

  error_log( "[cf7-debug] validate called. tag_name={$name}, tag_type={$type}, value={$value}" );

  // --- カタカナチェック（既存ロジック） ---
  if ( $name === 'your-kana' && $value !== '' ) {
    if ( ! preg_match( '/^[ァ-ヶー\s]+$/u', $value ) ) {
      error_log( "[cf7-debug] your-kana invalid (not katakana): {$value}" );
      $result->invalidate( $tag, '全角カタカナで入力してください' );
    } else {
      error_log( "[cf7-debug] your-kana ok: {$value}" );
    }
  }

  // --- tel は今回ハイフン許可の想定 ---
  if ( in_array( $name, array( 'your-tel', 'your-fax' ), true ) ) {
    error_log( "[cf7-debug] tel check for {$name} value={$value}" );
    if ( $value !== '' && ! preg_match( '/^[0-9\-]+$/', $value ) ) {
      error_log( "[cf7-debug] tel invalid: {$value}" );
      $result->invalidate( $tag, '半角数字とハイフンのみ使用できます（例: 090-0000-0000）' );
    } else {
      error_log( "[cf7-debug] tel ok: {$value}" );
    }
  }

  return $result;
}

// 各フィールドタイプにフック
add_filter( 'wpcf7_validate_text',  'debug_wpcf7_validate', 11, 2 );
add_filter( 'wpcf7_validate_text*', 'debug_wpcf7_validate', 11, 2 );
add_filter( 'wpcf7_validate_tel',   'debug_wpcf7_validate', 11, 2 );
add_filter( 'wpcf7_validate_tel*',  'debug_wpcf7_validate', 11, 2 );