# 資料驗證模組 [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## 用法

### 單一驗證
- 參數:
  - `id`: HTML TAG 的 ID
  - `value`: 被驗證的值
  - `code`: 驗證格式索引(如Name、Email、Adrress、...)
  - `allowEmpty`: 允許欄位為空值
  - `minLength`: 輸入的最小長度
```js
$valid = sgwValidate(id, value, code, allowEmpty, minLength);
```

### 批次驗證
使用sgw Html Tag 參數:
- `id="example"`: 設定欄位的ID
- `class="sgwValid"`: 初始化
- `sgwValid="索引值"`: 填入索引值，驗證格式
- `sgwMinLength="數字"`: 填入數字，欄位最小長度
- `sgwAllowEmpty="true"`: 填入Boolean值，是否允許空白，預設`false`

```html
<input id="example" class="sgwValid" sgwValid="Email" sgwMinLength="3" sgwAllowEmpty="true" type="text">
```

## 回傳值
- 型態: `Array`
- `id`: HTML的ID
- `value`: 驗證的值
- `code`: 驗證的格式
- `error`: 
  - `-2`: 未設定ID
  - `-1`: 未設定驗證格式
  - `0`: 正確(通過驗證)
  - `1`: 未通過驗證
  - `2`: 欄位空值錯誤
  - `4`: 最小長度錯誤
  
## 驗證格式索引
- `Name`: 驗證中英文姓名
- `Mobile`: 驗證手機號(台)，如09XXXXXXXX、8869XXXXXXXX、+8869XXXXXXXX
- `Tel`: 驗證中英文姓名
- `Address`: 驗證中英文姓名
- `Email`: 驗證中英文姓名
- `Integer`: 驗證中英文姓名
- `PositiveInt`: 驗證中英文姓名
- `Numeric`: 驗證中英文姓名
- `Url`: 驗證中英文姓名
- `Youtube`: 驗證中英文姓名
- `Account`: 驗證中英文姓名
- `Password_01`: 任意字
- `Password_02`: 至少 1字母 1數字
- `Password_03`: 至少 1大寫字母 1小寫字母 1數字
