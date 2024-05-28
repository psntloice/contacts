const base_url = "http://localhost:8000/";

const get_call_module = async (path, token) => {
  const res = await fetch(`${base_url}/${path}`, {
    headers: {
      "Content-Type": "application/json",
    },
  });

  const res_data = res.json();

  return res_data;
};


const post_call_module = async (body, path) => {
  const res = await fetch(`${base_url}/${path}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(body),
  });

  const res_data = res.json();

  return res_data;
};

export { post_call_module, get_call_module };
